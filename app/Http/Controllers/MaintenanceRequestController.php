<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MaintenanceRequestController extends Controller
{
    /**
     * Display a listing of maintenance requests for the authenticated landlord's properties.
     */
    public function index()
    {
        $requests = MaintenanceRequest::with(['unit.property', 'tenant'])
            ->whereHas('unit.property', function ($query) {
                $query->where('landlord_id', Auth::id());
            })
            ->latest()
            ->get();

        return view('landlord.maintenance-requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new maintenance request.
     */
    public function create()
    {
        $units = Unit::whereHas('property', function ($query) {
            $query->where('landlord_id', Auth::id());
        })->get();

        return view('landlord.maintenance.create', compact('units'));
    }

    /**
     * Store a newly created maintenance request in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'unit_id' => [
                'required',
                'integer',
                Rule::exists('units', 'id')->where(function ($query) {
                    $query->whereHas('property', function ($q) {
                        $q->where('landlord_id', Auth::id());
                    });
                }),
            ],
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'priority' => 'required|in:low,medium,high,emergency',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);

        $maintenanceRequest = MaintenanceRequest::create($request->only([
            'unit_id', 'title', 'description',
            'priority', 'status'
        ]));

        return redirect()->route('maintenance.index')
            ->with('success', 'Maintenance request created successfully!');
    }

    /**
     * Display the specified maintenance request.
     */
    public function show($id)
    {
        $request = MaintenanceRequest::with(['unit.property', 'tenant'])
            ->whereHas('unit.property', function ($query) {
                $query->where('landlord_id', Auth::id());
            })
            ->findOrFail($id);

        return view('landlord.maintenance.show', compact('request'));
    }

    /**
     * Show the form for editing the specified maintenance request.
     */
    public function edit($id)
    {
        $request = MaintenanceRequest::whereHas('unit.property', function ($query) {
            $query->where('landlord_id', Auth::id());
        })->findOrFail($id);

        $units = Unit::whereHas('property', function ($query) {
            $query->where('landlord_id', Auth::id());
        })->get();

        return view('landlord.maintenance.edit', compact('request', 'units'));
    }

    /**
     * Update the specified maintenance request in storage.
     */
    public function update(Request $request, $id)
    {
        $maintenanceRequest = MaintenanceRequest::whereHas('unit.property', function ($query) {
            $query->where('landlord_id', Auth::id());
        })->findOrFail($id);

        $request->validate([
            'unit_id' => [
                'required',
                'integer',
                Rule::exists('units', 'id')->where(function ($query) {
                    $query->whereHas('property', function ($q) {
                        $q->where('landlord_id', Auth::id());
                    });
                }),
            ],
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'priority' => 'required|in:low,medium,high,emergency',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);

        $maintenanceRequest->update($request->only([
            'unit_id', 'title', 'description',
            'priority', 'status'
        ]));

        return redirect()->route('maintenance.index')
            ->with('success', 'Maintenance request updated successfully!');
    }

    /**
     * Remove the specified maintenance request from storage.
     */
    public function destroy($id)
    {
        $request = MaintenanceRequest::whereHas('unit.property', function ($query) {
            $query->where('landlord_id', Auth::id());
        })->findOrFail($id);

        $request->delete();

        return redirect()->route('maintenance.index')
            ->with('success', 'Maintenance request deleted successfully!');
    }

    /**
     * Mark a maintenance request as resolved.
     */
    public function resolve($id)
    {
        $request = MaintenanceRequest::whereHas('unit.property', function ($query) {
            $query->where('landlord_id', Auth::id());
        })->findOrFail($id);

        $request->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        return redirect()->route('maintenance.show', $request->id)
            ->with('success', 'Maintenance request marked as completed!');
    }
}
