<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController,
    PropertyController,
    UnitController,
    TenantController,
    LeaseController,
    PaymentController,
    MaintenanceController,
    NotificationController,
    DashboardController
};

// Default landing page (can be login or dashboard)
Route::get('/', function () {
    return view('welcome');
});

// Dashboard (role-based access inside controller)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Users (Admin only)
Route::resource('users', UserController::class);

// Properties & Units (Landlord)
Route::resource('properties', PropertyController::class);
Route::resource('units', UnitController::class);

// Tenants (Admin / Landlord)
Route::resource('tenants', TenantController::class);

// Leases
Route::resource('leases', LeaseController::class);

// Payments
Route::resource('payments', PaymentController::class);
// custom action to make a payment
Route::post('payments/{lease}/pay', [PaymentController::class, 'pay'])->name('payments.pay');

// Maintenance Requests
Route::resource('maintenance', MaintenanceController::class);
// custom action to resolve maintenance request
Route::post('maintenance/{request}/resolve', [MaintenanceController::class, 'resolve'])->name('maintenance.resolve');

// Notifications
Route::resource('notifications', NotificationController::class);
