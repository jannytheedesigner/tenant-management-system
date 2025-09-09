<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index() {
        return Property::with('units')->get();
    }

    public function store(Request $request) {
        $property = Property::create($request->all());
        return response()->json($property, 201);
    }

    public function show($id) {
        return Property::with('units')->findOrFail($id);
    }

    public function update(Request $request, $id) {
        $property = Property::findOrFail($id);
        $property->update($request->all());
        return response()->json($property, 200);
    }

    public function destroy($id) {
        Property::destroy($id);
        return response()->json(null, 204);
    }
}
