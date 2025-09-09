<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = ['property_id', 'unit_number', 'rent_amount', 'status'];

    // A unit belongs to a property
    public function property() {
        return $this->belongsTo(Property::class, 'property_id');
    }

    // A unit can have many leases over time
    public function leases() {
        return $this->hasMany(Lease::class, 'unit_id');
    }

    // A unit can have many maintenance requests
    public function maintenanceRequests() {
        return $this->hasMany(MaintenanceRequest::class, 'unit_id');
    }
}
