<?php

namespace App\Http\Controllers;

use App\Models\TireType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TireTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tireTypes = TireType::all();
        return view('tire-types.index', compact('tireTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tire-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $tireType = new TireType();
        $tireType->name_en = $validated['name_en'];
        $tireType->name_ar = $validated['name_ar'];
        $tireType->description = $validated['description'] ?? null;
        $tireType->created_by = Auth::id();
        $tireType->save();

        return redirect()->route('tire-types.index')
            ->with('success', 'Tire type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TireType $tireType)
    {
        return view('tire-types.show', compact('tireType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TireType $tireType)
    {
        return view('tire-types.edit', compact('tireType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TireType $tireType)
    {
        $validated = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $tireType->name_en = $validated['name_en'];
        $tireType->name_ar = $validated['name_ar'];
        $tireType->description = $validated['description'] ?? $tireType->description;
        $tireType->updated_by = Auth::id();
        $tireType->save();

        return redirect()->route('tire-types.index')
            ->with('success', 'Tire type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TireType $tireType)
    {
        // Soft delete
        $tireType->deleted_by = Auth::id();
        $tireType->deleted_at = now();
        $tireType->save();

        return redirect()->route('tire-types.index')
            ->with('success', 'Tire type deleted successfully.');
    }
}
