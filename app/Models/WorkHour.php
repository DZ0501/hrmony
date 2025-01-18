<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkHour extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'hours_worked',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
