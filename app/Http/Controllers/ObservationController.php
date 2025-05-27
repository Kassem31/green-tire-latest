<?php

namespace App\Http\Controllers;

use App\Models\Observation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ObservationController extends Controller
{
    /**
     * Display a listing of the observations.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Observation::query();

        

        // Apply Arabic name filter if provided
        if ($request->filled('name_ar')) {
            $query->where('name_ar', 'LIKE', '%' . $request->name_ar . '%');
        }

        // Apply English name filter if provided
        if ($request->filled('name_en')) {
            $query->where('name_en', 'LIKE', '%' . $request->name_en . '%');
        }

        // Get filtered observations
        $observations = $query->get();

        return view('observations.index', compact('observations'));
    }

    /**
     * Show the form for creating a new observation.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('observations.create');
    }

    /**
     * Store a newly created observation in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        $validated['created_by'] = Auth::user()->id;
        $validated['updated_by'] = Auth::user()->id;


        Observation::create($validated);

        return redirect()->route('observations.index')
                         ->with('success', 'Observation created successfully.');
    }

    /**
     * Display the specified observation.
     *
     * @param  \App\Models\Observation  $observation
     * @return \Illuminate\View\View
     */
    public function show(Observation $observation)
    {
        return view('observations.show', compact('observation'));
    }

    /**
     * Show the form for editing the specified observation.
     *
     * @param  \App\Models\Observation  $observation
     * @return \Illuminate\View\View
     */
    public function edit(Observation $observation)
    {
        return view('observations.edit', compact('observation'));
    }

    /**
     * Update the specified observation in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Observation  $observation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Observation $observation)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);


        $validated['updated_by'] = Auth::user()->id;


        $observation->update($validated);

        return redirect()->route('observations.index')
                         ->with('success', 'Observation updated successfully.');
    }

    /**
     * Remove the specified observation from storage.
     *
     * @param  \App\Models\Observation  $observation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Observation $observation)
    {
        // Check if the observation is being used in any inspection transactions
        if ($observation->inspectionTransactions()->count() > 0) {
            return redirect()->route('observations.index')
                            ->with('error', 'Cannot delete this observation as it is being used in inspection transactions.');
        }

        // If not in use, proceed with deletion
        // $observation->deleted_by = Auth::id();
        // $observation->save();

        $observation->delete();

        return redirect()->route('observations.index')
                        ->with('success', 'Observation deleted successfully.');
    }
}
