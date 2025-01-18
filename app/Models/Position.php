<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = ['name', 'description'];

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }
    public function jobOffers()
    {
        return $this->hasMany(JobOffer::class);
    }
    public function responsibilities()
    {
        return $this->belongsToMany(Responsibility::class, 'position_responsibility');
    }

    public function requirements()
    {
        return $this->belongsToMany(Requirement::class, 'position_requirement');
    }
}
