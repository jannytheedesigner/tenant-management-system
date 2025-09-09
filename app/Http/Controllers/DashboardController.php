<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Lease;
use App\Models\Payment;
use App\Models\MaintenanceRequest;

class DashboardController extends Controller
{
    // Admin dashboard
    public function admin()
    {
        $user = Auth::user();

        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }

        return view('dashboard.admin', compact('user'));
    }

    // Landlord dashboard
    public function landlord()
    {
        $user = Auth::user();

        if ($user->role !== 'landlord') {
            abort(403, 'Unauthorized access.');
        }

        $properties = $user->properties()->with('units')->get();
        $totalProperties = $properties->count();
        $totalUnits = $properties->sum(fn($property) => $property->units->count());
        $occupiedUnits = $properties->sum(fn($property) => $property->units->where('status', 'occupied')->count());
        $vacantUnits = $totalUnits - $occupiedUnits;

        $leases = Lease::whereHas('unit.property', fn($q) => $q->where('landlord_id', $user->id))
            ->with('tenant')
            ->latest()
            ->take(5)
            ->get();

        $payments = Payment::whereHas('lease.unit.property', fn($q) => $q->where('landlord_id', $user->id))
            ->with('lease.tenant')
            ->latest()
            ->take(5)
            ->get();

        $maintenanceRequests = MaintenanceRequest::whereHas('unit.property', fn($q) => $q->where('landlord_id', $user->id))
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.landlord', compact(
            'user', 'totalProperties', 'totalUnits', 'occupiedUnits',
            'vacantUnits', 'leases', 'payments', 'maintenanceRequests'
        ));
    }


    // Tenant dashboard
    public function tenant()
    {
        $user = Auth::user();

        if ($user->role !== 'tenant') {
            abort(403, 'Unauthorized access.');
        }

        // Eager-load tenant data
        $lease = $user->leases()->with('unit.property')->latest()->first();
        $payments = $user->leases()->with('payments')->get()->pluck('payments')->flatten();
        $maintenanceRequests = $user->maintenanceRequests()->latest()->take(5)->get();
        $notifications = $user->notifications()->latest()->take(5)->get();

        return view('dashboard.tenant', compact(
            'user', 'lease', 'payments', 'maintenanceRequests', 'notifications'
        ));
    }

}
