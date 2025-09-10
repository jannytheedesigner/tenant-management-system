<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    /**
     * Display a listing of the landlord's properties.
     */
    public function index()
    {
        $properties = Property::with('units')
            ->where('landlord_id', Auth::id()) // 👈 only show landlord’s own
            ->get();

        return view('landlord.properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new property.
     */
    public function create()
    {
        return view('landlord.properties.create');
    }

    /**
     * Store a newly created property.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        Property::create([
            'name'        => $request->name,
            'location'    => $request->location,
            'landlord_id' => Auth::id(), // 👈 attach logged-in landlord
        ]);

        return redirect()->route('properties.index')
            ->with('success', 'Property created successfully!');
    }

    /**
     * Display the specified property.
     */
    public function show($id)
    {
        $property = Property::with('units')
            ->where('landlord_id', Auth::id()) // 👈 ensure ownership
            ->findOrFail($id);

        return view('landlord.properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified property.
     */
    public function edit($id)
    {
        $property = Property::where('landlord_id', Auth::id())->findOrFail($id);

        return view('landlord.properties.edit', compact('property'));
    }

    /**
     * Update the specified property in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $property = Property::where('landlord_id', Auth::id())->findOrFail($id);
        $property->update($request->only(['name', 'location']));

        return redirect()->route('properties.index')
            ->with('success', 'Property updated successfully!');
    }

    /**
     * Remove the specified property from storage.
     */
    public function destroy($id)
    {
        $property = Property::where('landlord_id', Auth::id())->findOrFail($id);
        $property->delete();

        return redirect()->route('properties.index')
            ->with('success', 'Property deleted successfully!');
    }
}
