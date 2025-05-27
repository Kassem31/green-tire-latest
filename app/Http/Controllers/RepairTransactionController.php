<?php

namespace App\Http\Controllers;

use App\Models\InspectionTransaction;
use App\Models\RepairStep;
use App\Models\RepairTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RepairTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $repairTransactions = RepairTransaction::with(['inspectionTransaction', 'repairSteps'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('repair-transactions.index', compact('repairTransactions'));
    }

    /**
     * Display a listing of pending repair transactions.
     */
    public function pending(Request $request)
    {
        $query = RepairTransaction::with(['inspectionTransaction', 'repairSteps'])
            ->where('decision', 'pending');

        // Filter by ID
        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        // Filter by inspection barcode
        if ($request->filled('barcode')) {
            $query->whereHas('inspectionTransaction', function($q) use ($request) {
                $q->where('barcode', 'LIKE', '%' . $request->barcode . '%');
            });
        }

        // Filter by tire type
        if ($request->filled('tire_type_id')) {
            $query->whereHas('inspectionTransaction', function($q) use ($request) {
                $q->where('tire_type_id', $request->tire_type_id);
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $pendingTransactions = $query->orderBy('created_at', 'desc')->paginate(10);
        $tireTypes = \App\Models\TireType::all();

        return view('repair-transactions.pending', compact('pendingTransactions', 'tireTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $inspectionId = $request->query('inspection_id');
        if (!$inspectionId) {
            return redirect()->route('inspection-transactions.index')
                ->with('error', 'Inspection ID is required to create a repair transaction.');
        }

        $inspectionTransaction = InspectionTransaction::findOrFail($inspectionId);

        // Check if this inspection already has a repair transaction
        if ($inspectionTransaction->repairTransaction) {
            return redirect()->route('repair-transactions.edit', $inspectionTransaction->repairTransaction->id)
                ->with('info', 'This inspection already has a repair transaction. You can edit it here.');
        }

        // Only allow creating repair transactions for inspections with 'repair' decision
        if (strtolower($inspectionTransaction->decision) !== 'repair') {
            return redirect()->route('inspection-transactions.index')
                ->with('error', 'Only inspection transactions with "repair" decision can have repair steps added.');
        }

        $repairSteps = RepairStep::all();

        return view('repair-transactions.create', compact('inspectionTransaction', 'repairSteps'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inspection_transaction_id' => 'required|exists:inspection_transactions,id',
            'decision' => 'required|string|in:repair,scrap,pending',
            'repair_steps' => 'required_if:decision,repair|array',
            'repair_steps.*' => 'exists:repair_steps,id',
        ]);


        // Create the repair transaction
        $repairTransaction = RepairTransaction::create([
            'inspection_transaction_id' => $validated['inspection_transaction_id'],
            'decision' => $validated['decision'],
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);


        $barcode = $repairTransaction->inspectionTransaction->barcode;

        DB::connection('SP_Connection')->statement('EXEC [dbo].SET_BLOCK_GT_BAPTIZE @Barcode = ?, @IS_blocked = ?', [
                $barcode,
                1  // Setting IS_blocked to 0 (false)
            ]);

            if ($validated['decision'] === 'repair' && !empty($validated['repair_steps'])) {

            DB::connection('SP_Connection')->statement('EXEC [dbo].SET_BLOCK_GT_BAPTIZE @Barcode = ?, @IS_blocked = ?', [
                $barcode,
                0  // Setting IS_blocked to 0 (false)
            ]);
            $repairTransaction->repairSteps()->attach($validated['repair_steps'], [
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Update the inspection transaction is_repaired status
        $inspectionTransaction = InspectionTransaction::find($validated['inspection_transaction_id']);
        $inspectionTransaction->update([
            'is_repaired' => true,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('inspection-transactions.index')
            ->with('success', 'Repair transaction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RepairTransaction $repairTransaction)
    {
        $repairTransaction->load(['inspectionTransaction', 'repairSteps']);
        return view('repair-transactions.show', compact('repairTransaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RepairTransaction $repairTransaction)
    {
        $repairTransaction->load(['inspectionTransaction', 'repairSteps']);
        $inspectionTransaction = $repairTransaction->inspectionTransaction;
        $repairSteps = RepairStep::all();
        $selectedRepairSteps = $repairTransaction->repairSteps->pluck('id')->toArray();

        return view('repair-transactions.edit', compact('repairTransaction', 'inspectionTransaction', 'repairSteps', 'selectedRepairSteps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RepairTransaction $repairTransaction)
    {
        $validated = $request->validate([
            'decision' => 'required|string|in:repair,scrap,pending',
            'repair_steps' => 'required_if:decision,repair|array',
            'repair_steps.*' => 'exists:repair_steps,id',
        ]);

        // Update the repair transaction
        $repairTransaction->update([
            'decision' => $validated['decision'],
            'updated_by' => Auth::id(),
        ]);

        // Sync repair steps if decision is repair
        if ($validated['decision'] === 'repair') {
            $syncData = [];
            foreach ($validated['repair_steps'] as $stepId) {
                $syncData[$stepId] = [
                    'updated_by' => Auth::id(),
                    'updated_at' => now(),
                ];
            }
            $repairTransaction->repairSteps()->sync($syncData);
        } else {
            // Remove all repair steps if decision is not repair
            $repairTransaction->repairSteps()->detach();
        }

        return redirect()->route('repair-transactions.index')
            ->with('success', 'Repair transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RepairTransaction $repairTransaction)
    {
        // Update the inspection transaction is_repaired status back to false
        $inspectionTransaction = $repairTransaction->inspectionTransaction;
        $inspectionTransaction->update([
            'is_repaired' => false,
            'updated_by' => Auth::id(),
        ]);

        // Mark as deleted with user ID
        $repairTransaction->deleted_by = Auth::id();
        $repairTransaction->save();

        // Delete the repair transaction (soft delete)
        $repairTransaction->delete();

        return redirect()->route('repair-transactions.index')
            ->with('success', 'Repair transaction deleted successfully.');
    }
}
