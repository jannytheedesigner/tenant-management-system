<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lease extends Model
{
    use HasFactory;

    protected $fillable = ['unit_id', 'tenant_id', 'start_date', 'end_date', 'status'];

    // A lease belongs to a unit
    public function unit() {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    // A lease belongs to a tenant (User)
    public function tenant() {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    // A lease has many payments
    public function payments() {
        return $this->hasMany(Payment::class, 'lease_id');
    }
}
