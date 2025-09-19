<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    /**
     * Display a listing of all units belonging to the authenticated landlord.
     */
    public function index()
    {
        $units = \App\Models\Unit::with('property')->latest()->get();
        $properties = \App\Models\Property::select('id','name')->orderBy('name')->get(); 
        return view('landlord.units.index', compact('units', 'properties'));
    }

    /**
     * Show the form for creating a new unit under a specific property.
     */
    public function create(Property $property)
    {
        return view('landlord.units.create', compact('property'));
    }

    /**
     * Store a newly created unit.
     */
    public function store(Request $request, Property $property)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'type'   => 'required|string|max:100',
            'rent'   => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);

        // Ensure landlord owns the property
        $property = \App\Models\Property::where('landlord_id', Auth::id())->findOrFail($propertyId);

        $property->units()->create($request->only(['name', 'type', 'rent', 'status']));

        return redirect()->route('units.index')
            ->with('success', 'Unit created successfully!');
    }

    /**
     * Display the specified unit.
     */
    public function show($unitId)
    {
        $unit = Unit::with('property')
            ->whereHas('property', function ($query) {
                $query->where('landlord_id', Auth::id());
            })
            ->findOrFail($unitId);

        return view('landlord.units.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified unit.
     */
    public function edit($unitId)
    {
        $unit = Unit::whereHas('property', function ($query) {
            $query->where('landlord_id', Auth::id());
        })->findOrFail($unitId);

        return view('landlord.units.edit', compact('unit'));
    }

    /**
     * Update the specified unit in storage.
     */
    public function update(Request $request, $unitId)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'type'   => 'required|string|max:100',
            'rent'   => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);

        $unit = Unit::whereHas('property', function ($query) {
            $query->where('landlord_id', Auth::id());
        })->findOrFail($unitId);

        $unit->update($request->only(['name', 'type', 'rent', 'status']));

        return redirect()->route('units.index')
            ->with('success', 'Unit updated successfully!');
    }

    /**
     * Remove the specified unit from storage.
     */
    public function destroy($unitId)
    {
        $unit = Unit::whereHas('property', function ($query) {
            $query->where('landlord_id', Auth::id());
        })->findOrFail($unitId);

        $unit->delete();

        return redirect()->route('units.index')
            ->with('success', 'Unit deleted successfully!');
    }
}
