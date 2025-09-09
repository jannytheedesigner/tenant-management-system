<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
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

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| These come from Breeze/Jetstream. Leave them as-is.
| They include: /login, /register, /forgot-password, etc.
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Role-based dashboards. Protected by auth + verified email.
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])
        ->name('dashboard.admin');
    Route::get('/dashboard/landlord', [DashboardController::class, 'landlord'])
        ->name('dashboard.landlord');
    Route::get('/dashboard/tenant', [DashboardController::class, 'tenant'])
        ->name('dashboard.tenant');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Only accessible to users with role = admin.
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});

/*
|--------------------------------------------------------------------------
| Landlord Routes
|--------------------------------------------------------------------------
|
| Accessible to landlords (and possibly admins if needed).
*/
Route::middleware(['auth', 'role:landlord,admin'])->group(function () {
    Route::resource('properties', PropertyController::class);
    Route::resource('units', UnitController::class);
    Route::resource('tenants', TenantController::class); // assign tenants
    Route::resource('leases', LeaseController::class);
    Route::resource('payments', PaymentController::class);

    // Custom landlord actions
    Route::post('payments/{lease}/pay', [PaymentController::class, 'pay'])
        ->name('payments.pay');
});

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Accessible to tenants (and possibly admins if needed).
*/
Route::middleware(['auth', 'role:tenant,admin'])->group(function () {
    Route::resource('maintenance', MaintenanceController::class);
    Route::post('maintenance/{request}/resolve', [MaintenanceController::class, 'resolve'])
        ->name('maintenance.resolve');

    Route::resource('notifications', NotificationController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
