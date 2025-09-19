<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Property;
use Illuminate\Http\Request;

class UnitController extends Controller
{

    public function index($propertyId) {
        $property = Property::findOrFail($propertyId);
        $units = $property->units()->with('property')->get();
        return view('landlord.units.index', compact('units', 'property'));
    }


    public function store(Request $request, $propertyId) {
        $property = Property::findOrFail($propertyId);
        $unit = $property->units()->create($request->all());
        return redirect()->route('units.index', $property->id)->with('success', 'Unit created successfully.');
    }


    public function show($propertyId, $unitId) {
        $property = Property::findOrFail($propertyId);
        $unit = $property->units()->with('property')->findOrFail($unitId);
        return view('landlord.units.show', compact('unit', 'property'));
    }


    public function update(Request $request, $propertyId, $unitId) {
        $property = Property::findOrFail($propertyId);
        $unit = $property->units()->findOrFail($unitId);
        $unit->update($request->all());
        return redirect()->route('units.index', $property->id)->with('success', 'Unit updated successfully.');
    }


    public function destroy($propertyId, $unitId) {
        $property = Property::findOrFail($propertyId);
        $property->units()->findOrFail($unitId)->delete();
        return redirect()->route('units.index', $property->id)->with('success', 'Unit deleted successfully.');
    }

    public function create($propertyId) {
        $property = Property::findOrFail($propertyId);
        return view('landlord.units.create', compact('property'));
    }

    public function edit($propertyId, $unitId) {
        $property = Property::findOrFail($propertyId);
        $unit = $property->units()->findOrFail($unitId);
        return view('landlord.units.edit', compact('unit', 'property'));
    }
}
