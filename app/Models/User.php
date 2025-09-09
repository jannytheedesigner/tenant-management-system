<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'contact',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Laravel 10+ feature: auto hashes passwords
    ];

    /* ===========================
       RELATIONSHIPS
    ============================ */

    // A landlord has many properties
    public function properties()
    {
        return $this->hasMany(Property::class, 'landlord_id');
    }

    // A tenant has one profile
    public function tenantProfile()
    {
        return $this->hasOne(TenantProfile::class, 'user_id');
    }

    // A tenant has many leases
    public function leases()
    {
        return $this->hasMany(Lease::class, 'tenant_id');
    }

    // A tenant has many maintenance requests
    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class, 'tenant_id');
    }

    // A user has many notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }
}
