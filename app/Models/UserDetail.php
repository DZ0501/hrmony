<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = ['user_id', 'sex', 'department', 'position', 'address', 'address2', 'city', 'postcode', 'phone_no'];

    // Relationship with User (One-to-One)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
