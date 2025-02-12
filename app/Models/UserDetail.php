<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'user_id',
        'manager_id',
        'position_id',
        'sex',
        'department',
        'address',
        'address2',
        'city',
        'postcode',
        'phone_no',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

}
