<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOfferRequirement extends Model
{
    protected $fillable = ['job_offer_id', 'requirement'];

    public function jobOffer()
    {
        return $this->belongsTo(JobOffer::class);
    }
}
