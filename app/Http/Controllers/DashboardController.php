<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('dashboard.admin', compact('user'));
        } elseif ($user->role === 'landlord') {
            return view('dashboard.landlord', compact('user'));
        } else {
            return view('dashboard.tenant', compact('user'));
        }
    }
}
