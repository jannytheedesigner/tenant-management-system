<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index() {
        return Unit::with('property')->get();
    }

    public function store(Request $request) {
        return Unit::create($request->all());
    }

    public function show($id) {
        return Unit::with('property')->findOrFail($id);
    }

    public function update(Request $request, $id) {
        $unit = Unit::findOrFail($id);
        $unit->update($request->all());
        return $unit;
    }

    public function destroy($id) {
        return Unit::destroy($id);
    }
}
