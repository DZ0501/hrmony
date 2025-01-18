<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = [
        'user_id',
        'reviewer_id',
        'job_offer_id',
        'stage',
        'decision',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
    public function jobOffer()
    {
        return $this->belongsTo(JobOffer::class);
    }
    public function answers()
    {
        return $this->hasMany(JobApplicationAnswer::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
