<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WorkHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'start_time',
        'end_time',
        'total_hours',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedTotalHoursAttribute()
    {
        return $this->total_hours ? number_format($this->total_hours, 2) . ' hours' : null;
    }

    public function scopeWithinDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    protected static function booted()
    {
        static::saving(function ($workHour) {
            if ($workHour->start_time && $workHour->end_time) {
                $workHour->total_hours = round(
                    Carbon::parse($workHour->start_time)->diffInMinutes(Carbon::parse($workHour->end_time)) / 60,
                    2
                );
            }
        });
    }
}
