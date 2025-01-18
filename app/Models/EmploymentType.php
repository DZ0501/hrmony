<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmploymentType extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];

    public function jobOffers()
    {
        return $this->belongsToMany(JobOffer::class, 'employment_type_job_offer');
    }
}
