<?php
namespace App\Http\Controllers;

use App\Models\RepairStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepairStepController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = RepairStep::query();

        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('name_ar', 'LIKE', '%' . $request->name . '%')
                    ->orWhere('name_en', 'LIKE', '%' . $request->name . '%');
            });
        }
        $repairSteps = $query->get();
        return view('repair-steps.index', compact('repairSteps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('repair-steps.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        $userId = Auth::user()->id;

        $validated['created_by'] = $userId;
        $validated['updated_by'] = $userId;

        RepairStep::create($validated);

        return redirect()->route('repair-steps.index')
            ->with('success', 'Repair step created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RepairStep $repairStep)
    {
        return view('repair-steps.show', compact('repairStep'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RepairStep $repairStep)
    {
        return view('repair-steps.edit', compact('repairStep'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RepairStep $repairStep)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        $userId = Auth::user()->id;

        $validated['updated_by'] = $userId;

        $repairStep->update($validated);

        return redirect()->route('repair-steps.index')
            ->with('success', 'Repair step updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RepairStep $repairStep)
    {
        // Check if repair step is used in any repair transactions
        if ($repairStep->repairTransactions()->count() > 0) {
            return redirect()->route('repair-steps.index')
                ->with('error', 'Cannot delete this repair step as it is being used in repair transactions.');
        }

        $userId = Auth::user()->id;

        $repairStep->deleted_by = $userId;
        $repairStep->save();
        $repairStep->delete();

        return redirect()->route('repair-steps.index')
            ->with('success', 'Repair step deleted successfully.');
    }
}
