<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    protected $fillable = [
        'position_id',
        'offered_salary_min',
        'offered_salary_max',
        'job_location',
        'work_schedule',
        'employment_type',
        'work_mode',
        'published',
        'created_by',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
    public function question()
    {
        return $this->belongsToMany(Question::class, 'job_offer_question')
            ->withPivot('order')
            ->orderBy('pivot_order');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function employmentTypes()
    {
        return $this->belongsToMany(EmploymentType::class, 'employment_type_job_offer');
    }
    public function workSchedules()
    {
        return $this->belongsToMany(WorkSchedule::class, 'job_offer_work_schedule');
    }

    public function workModes()
    {
        return $this->belongsToMany(WorkMode::class, 'job_offer_work_mode');
    }

}
