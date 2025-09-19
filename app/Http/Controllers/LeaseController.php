<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use App\Models\Property;
use Illuminate\Http\Request;

class LeaseController extends Controller
{
    public function index($propertyId) {
        $property = Property::with('units')->findOrFail($propertyId);
        $leases = Lease::with(['unit', 'tenant'])->whereIn('unit_id', $property->units->pluck('id'))->get();
        return view('landlord.leases.index', compact('leases', 'property'));
    }

    public function store(Request $request, $propertyId) {
        $property = Property::with('units')->findOrFail($propertyId);
        $lease = Lease::create($request->all());
        return redirect()->route('leases.index', $property->id)->with('success', 'Lease created successfully.');
    }

    public function show($propertyId, $leaseId) {
        $property = Property::with('units')->findOrFail($propertyId);
        $lease = Lease::with(['unit', 'tenant'])->findOrFail($leaseId);
        return view('landlord.leases.show', compact('lease', 'property'));
    }

    public function update(Request $request, $propertyId, $leaseId) {
        $property = Property::with('units')->findOrFail($propertyId);
        $lease = Lease::findOrFail($leaseId);
        $lease->update($request->all());
        return redirect()->route('leases.index', $property->id)->with('success', 'Lease updated successfully.');
    }

    public function destroy($propertyId, $leaseId) {
        $property = Property::findOrFail($propertyId);
        Lease::destroy($leaseId);
        return redirect()->route('leases.index', $property->id)->with('success', 'Lease deleted successfully.');
    }
    public function create($propertyId) {
        $property = Property::with('units')->findOrFail($propertyId);
        return view('landlord.leases.create', compact('property'));
    }
    public function edit($propertyId, $leaseId) {
        $property = Property::with('units')->findOrFail($propertyId);
        $lease = Lease::findOrFail($leaseId);
        return view('landlord.leases.edit', compact('lease', 'property'));
    }
}

