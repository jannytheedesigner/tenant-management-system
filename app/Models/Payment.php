<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['lease_id', 'amount', 'method', 'payment_date', 'status'];

    // A payment belongs to a lease
    public function lease() {
        return $this->belongsTo(Lease::class, 'lease_id');
    }
}
