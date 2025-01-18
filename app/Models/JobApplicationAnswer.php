<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplicationAnswer extends Model
{
    protected $fillable = ['job_application_id', 'question_id', 'user_id', 'answer'];

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
