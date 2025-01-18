<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkMode extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];

    public function jobOffers()
    {
        return $this->belongsToMany(JobOffer::class, 'job_offer_work_mode');
    }
}
