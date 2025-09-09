<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

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

        return view('dashboard.landlord', compact('user'));
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
