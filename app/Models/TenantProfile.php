<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantProfile extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'phone', 'address', 'emergency_contact'];

    // A profile belongs to a tenant (User)
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
