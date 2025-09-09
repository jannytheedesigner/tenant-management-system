<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use Illuminate\Http\Request;

class LeaseController extends Controller
{
    public function index() {
        return Lease::with(['unit', 'tenant'])->get();
    }

    public function store(Request $request) {
        return Lease::create($request->all());
    }

    public function show($id) {
        return Lease::with(['unit', 'tenant'])->findOrFail($id);
    }

    public function update(Request $request, $id) {
        $lease = Lease::findOrFail($id);
        $lease->update($request->all());
        return $lease;
    }

    public function destroy($id) {
        return Lease::destroy($id);
    }
}

