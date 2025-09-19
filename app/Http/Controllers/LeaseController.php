<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use App\Models\Unit;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LeaseController extends Controller
{
    /**
     * Display a listing of all leases belonging to the authenticated landlord's properties.
     */
    public function index()
    {
        $leases = Lease::with(['unit.property', 'tenant'])
            ->whereHas('unit.property', function ($query) {
                $query->where('landlord_id', Auth::id());
            })
            ->latest()
            ->get();

        return view('landlord.leases.index', compact('leases'));
    }

    /**
     * Show the form for creating a new lease.
     */
    public function create()
    {
        $units = Unit::whereHas('property', function ($query) {
            $query->where('landlord_id', Auth::id());
        })->with('property')->get();

        return view('landlord.leases.create', compact('units'));
    }

    /**
     * Store a newly created lease in storage.
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
            'tenant_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'rent_amount' => 'required|numeric|min:0',
            'status' => 'required|in:active,pending,terminated',
        ]);

        $lease = Lease::create($request->only([
            'unit_id', 'tenant_id', 'start_date', 
            'end_date', 'rent_amount', 'status'
        ]));

        return redirect()->route('leases.index')
            ->with('success', 'Lease created successfully!');
    }

    /**
     * Display the specified lease.
     */
    public function show($id)
    {
        $lease = Lease::with(['unit.property', 'tenant'])
            ->whereHas('unit.property', function ($query) {
                $query->where('landlord_id', Auth::id());
            })
            ->findOrFail($id);

        return view('landlord.leases.show', compact('lease'));
    }

    /**
     * Show the form for editing the specified lease.
     */
    public function edit($id)
    {
        $lease = Lease::whereHas('unit.property', function ($query) {
            $query->where('landlord_id', Auth::id());
        })->findOrFail($id);

        $units = Unit::whereHas('property', function ($query) {
            $query->where('landlord_id', Auth::id());
        })->with('property')->get();

        return view('landlord.leases.edit', compact('lease', 'units'));
    }

    /**
     * Update the specified lease in storage.
     */
    public function update(Request $request, $id)
    {
        $lease = Lease::whereHas('unit.property', function ($query) {
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
            'tenant_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'rent_amount' => 'required|numeric|min:0',
            'status' => 'required|in:active,pending,terminated',
        ]);

        $lease->update($request->only([
            'unit_id', 'tenant_id', 'start_date', 
            'end_date', 'rent_amount', 'status'
        ]));

        return redirect()->route('leases.index')
            ->with('success', 'Lease updated successfully!');
    }

    /**
     * Remove the specified lease from storage.
     */
    public function destroy($id)
    {
        $lease = Lease::whereHas('unit.property', function ($query) {
            $query->where('landlord_id', Auth::id());
        })->findOrFail($id);

        $lease->delete();

        return redirect()->route('leases.index')
            ->with('success', 'Lease deleted successfully!');
    }
}

