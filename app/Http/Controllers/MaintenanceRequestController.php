<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;

class MaintenanceRequestController extends Controller
{
    public function index() {
        return MaintenanceRequest::with(['tenant', 'unit'])->get();
    }

    public function store(Request $request) {
        return MaintenanceRequest::create($request->all());
    }

    public function show($id) {
        return MaintenanceRequest::with(['tenant', 'unit'])->findOrFail($id);
    }

    public function update(Request $request, $id) {
        $requestModel = MaintenanceRequest::findOrFail($id);
        $requestModel->update($request->all());
        return $requestModel;
    }

    public function destroy($id) {
        return MaintenanceRequest::destroy($id);
    }

    // Custom method for resolving requests
    public function resolve(MaintenanceRequest $request) {
        $request->update(['status' => 'resolved']);
        return response()->json($request, 200);
    }
}
