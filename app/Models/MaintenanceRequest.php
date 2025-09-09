<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $fillable = ['tenant_id', 'unit_id', 'description', 'status'];

    // A request belongs to a tenant (User)
    public function tenant() {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    // A request belongs to a unit
    public function unit() {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
