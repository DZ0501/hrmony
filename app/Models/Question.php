<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['name'];

    public function jobOffers()
    {
        return $this->belongsToMany(JobOffer::class, 'job_offer_questions')
            ->withPivot('order')
            ->orderBy('pivot_order');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'question_tag');
    }

}
