<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $fillable = [
        'employee_id',
        'request_type',
        'stage',
        'decision',
        'details',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
