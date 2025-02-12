<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentUsage extends Model
{
    use HasFactory;

    protected $table = 'equipment_usage';

    protected $fillable = [
        'equipment_id',
        'user_id',
        'assigned_at',
        'returned_at',
        'status',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
