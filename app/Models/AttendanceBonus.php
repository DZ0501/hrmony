<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceBonus extends Model
{
    protected $fillable = ['user_id', 'year', 'month', 'bonus_amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
