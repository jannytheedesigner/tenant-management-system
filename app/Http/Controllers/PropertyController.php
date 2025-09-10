<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the properties.
     */
    public function index()
    {
        $properties = Property::with('units')->get();
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

        Property::create($request->only(['name', 'location']));

        return redirect()->route('properties.index')
            ->with('success', 'Property created successfully!');
    }

    /**
     * Display the specified property.
     */
    public function show($id)
    {
        $property = Property::with('units')->findOrFail($id);
        return view('landlord.properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified property.
     */
    public function edit($id)
    {
        $property = Property::findOrFail($id);
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

        $property = Property::findOrFail($id);
        $property->update($request->only(['name', 'location']));

        return redirect()->route('properties.index')
            ->with('success', 'Property updated successfully!');
    }

    /**
     * Remove the specified property from storage.
     */
    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        $property->delete();

        return redirect()->route('properties.index')
            ->with('success', 'Property deleted successfully!');
    }
}
