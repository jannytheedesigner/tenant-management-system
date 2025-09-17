<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;

    protected $fillable = ['landlord_id', 'name', 'location', 'unit', 'description','rent_amount','status'];

    // A property belongs to a landlord
    public function landlord() {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    // A property has many units
    public function units() {
        return $this->hasMany(Unit::class, 'property_id');
    }
}
