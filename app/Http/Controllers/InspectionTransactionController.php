<?php
namespace App\Http\Controllers;

use App\Models\InspectionTransaction;
use App\Models\Observation;
use App\Models\TireType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InspectionTransactionController extends Controller
{

    /**
     * Display a listing of the inspection transactions.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = InspectionTransaction::with('tireType');

        if ($request->filled('barcode')) {
            $query->where('barcode', 'LIKE', '%' . $request->barcode . '%');
        }

        if ($request->filled('tire_type_id')) {
            $query->where('tire_type_id', $request->tire_type_id);
        }

        if ($request->filled('decision')) {
            $query->where('decision', 'LIKE', '%' . $request->decision . '%');
        }

        if ($request->filled('building_date')) {
            $date = $request->building_date;
            $query->whereDate('building_date', $date);
        }

        if ($request->filled('machine')) {
            $query->where('machine', 'LIKE', '%' . $request->machine . '%');
        }

        if ($request->filled('status')) {
            if ($request->status === 'repaired') {
                $query->where('is_repaired', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_repaired', false)
                    ->where('decision', 'repair');
            } elseif ($request->status === 'scrap') {
                $query->where('decision', 'scrap');
            }
        }

        // Implement backend pagination with 10 items per page
        $inspectionTransactions = $query->orderBy('created_at', 'desc')->paginate(10);
        $tireTypes = TireType::all();

        return view('inspection-transactions.index', compact('inspectionTransactions', 'tireTypes'));
    }

    /**
     * Display a listing of the pending inspection transactions.
     *
     * @return \Illuminate\View\View
     */
    public function pending()
    {
        $pendingTransactions = InspectionTransaction::with('tireType')
            ->where('decision', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('repair-transactions.pending', compact('pendingTransactions'));
    }

    /**
     * Show the form for creating a new inspection transaction.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $tireTypes = TireType::all();
        $observations = Observation::all();
        return view('inspection-transactions.create', compact('tireTypes', 'observations'));
    }

    /**
     * Store a newly created inspection transaction in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Check if the barcode already exists in inspection transactions
        $existingTransaction = InspectionTransaction::where('barcode', $request->barcode)
            ->withTrashed() // Include soft deleted records in the check
            ->first();

        if ($existingTransaction) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['barcode' => 'This barcode already exists in the system. Please use a different barcode.']);
        }

        // Validate that the barcode exists in the manufacturing system
        try {
            $results = DB::connection('SP_Connection')->select('EXEC [dbo].[gt_data] @Barcode = ?', [
                $request->barcode
            ]);

            // Check if barcode exists in the manufacturing data
            if (count($results) === 0 || !$results[0]->Barcode) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['barcode' => 'The barcode does not exist in the manufacturing system. Please use a valid barcode.']);
            }
        } catch (\Exception $e) {
            \Log::error('Barcode validation error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->withErrors(['barcode' => 'An error occurred while validating the barcode. Please try again.']);
        }
        if ($request->tire_type_id == TireType::GREEN_TIRE_ID) {
            $validated = $request->validate([
                'barcode' => 'required|string|max:255',
                'tire_type_id' => 'required|exists:tire_types,id',
                'decision' => 'required|string|max:255',
                'machine' => 'nullable|string|max:255',
                'operator_name' => 'nullable|string|max:255',
                'operator_code' => 'nullable|string|max:255',
                'observations' => 'nullable|array',
                'observations.*' => 'exists:observations,id'
            ]);
        } else {
            $validated = $request->validate([
                'barcode' => 'required|string|max:255',
                'tire_type_id' => 'required|exists:tire_types,id',
                'machine' => 'nullable|string|max:255',
                'operator_name' => 'nullable|string|max:255',
                'operator_code' => 'nullable|string|max:255',
                'observations' => 'nullable|array',
                'observations.*' => 'exists:observations,id'
            ]);
        };



        $validated['is_repaired'] = $request->has('is_repaired');
        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();
        $validated['building_date'] = $request->input('building_date', now());
        $validated['decision'] = $request->input('decision') ?? 'Repair';
        $inspectionTransaction = InspectionTransaction::create($validated);

        // Use statement() instead of select() since this stored procedure doesn't return a result set
        DB::connection('SP_Connection')->statement('EXEC [dbo].SET_BLOCK_GT_BAPTIZE @Barcode = ?, @IS_blocked = ?', [
            $validated['barcode'],
            1, // Setting IS_blocked to 1 (true)
        ]);

        if (!empty($validated['observations'])) {
            $inspectionTransaction->observations()->attach($validated['observations']);
        }

        return redirect()->route('inspection-transactions.index')
            ->with('success', 'Inspection transaction created successfully.');
    }

    /**
     * Display the specified inspection transaction.
     *
     * @param  \App\Models\InspectionTransaction  $inspectionTransaction
     * @return \Illuminate\View\View
     */
    public function show(InspectionTransaction $inspectionTransaction)
    {
        $inspectionTransaction->load(['tireType', 'observations', 'repairTransaction']);
        return view('inspection-transactions.show', compact('inspectionTransaction'));
    }

    /**
     * Show the form for editing the specified inspection transaction.
     *
     * @param  \App\Models\InspectionTransaction  $inspectionTransaction
     * @return \Illuminate\View\View
     */
    public function edit(InspectionTransaction $inspectionTransaction)
    {
        $tireTypes = TireType::all();
        $observations = Observation::all();
        $selectedObservations = $inspectionTransaction->observations->pluck('id')->toArray();
        return view('inspection-transactions.edit', compact('inspectionTransaction', 'tireTypes', 'observations', 'selectedObservations'));
    }

    /**
     * Update the specified inspection transaction in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InspectionTransaction  $inspectionTransaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, InspectionTransaction $inspectionTransaction)
    {
            // Check if the barcode already exists (excluding the current record)
        $existingTransaction = InspectionTransaction::where('barcode', $request->barcode)
            ->where('id', '!=', $inspectionTransaction->id)
            ->withTrashed() // Include soft deleted records in the check
            ->first();

        if ($existingTransaction) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['barcode' => 'This barcode is already used by another transaction. Please use a different barcode.']);
        }

        // Validate that the barcode exists in the manufacturing system
        try {
            $results = DB::connection('SP_Connection')->select('EXEC [dbo].[gt_data] @Barcode = ?', [
                $request->barcode
            ]);

            // Check if barcode exists in the manufacturing data
            if (count($results) === 0 || !$results[0]->Barcode) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['barcode' => 'The barcode does not exist in the manufacturing system. Please use a valid barcode.']);
            }
        } catch (\Exception $e) {
            \Log::error('Barcode validation error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->withErrors(['barcode' => 'An error occurred while validating the barcode. Please try again.']);
        }
        if ($request->tire_type_id == TireType::GREEN_TIRE_ID) {
            $validated = $request->validate([
                'barcode' => 'required|string|max:255',
                'tire_type_id' => 'required|exists:tire_types,id',
                'decision' => 'required|string|max:255',
                'machine' => 'nullable|string|max:255',
                'operator_name' => 'nullable|string|max:255',
                'operator_code' => 'nullable|string|max:255',
                'observations' => 'nullable|array',
                'observations.*' => 'exists:observations,id'
            ]);
        } else {
            $validated = $request->validate([
                'barcode' => 'required|string|max:255',
                'tire_type_id' => 'required|exists:tire_types,id',
                'machine' => 'nullable|string|max:255',
                'operator_name' => 'nullable|string|max:255',
                'operator_code' => 'nullable|string|max:255',
                'observations' => 'nullable|array',
                'observations.*' => 'exists:observations,id'
            ]);
        };

        $validated['is_repaired'] = $request->has('is_repaired');
        $validated['updated_by'] = Auth::id();
        $validated['decision'] = $request->input('decision') ?? 'Repair';

        $inspectionTransaction->update($validated);

        // Sync observations (attach new ones, detach removed ones)
        $observations = $request->input('observations', []);
        $inspectionTransaction->observations()->sync($observations);

        return redirect()->route('inspection-transactions.index')
            ->with('success', 'Inspection transaction updated successfully.');
    }

    /**
     * Remove the specified inspection transaction from storage.
     *
     * @param  \App\Models\InspectionTransaction  $inspectionTransaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(InspectionTransaction $inspectionTransaction)
    {
        $inspectionTransaction->deleted_by = Auth::id();
        $inspectionTransaction->save();

        $inspectionTransaction->delete();

        return redirect()->route('inspection-transactions.index')
            ->with('success', 'Inspection transaction deleted successfully.');
    }
}
