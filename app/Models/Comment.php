<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_application_id',
        'user_id',
        'content',
    ];

    /**
     * Get the user who created the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the job application the comment belongs to.
     */
    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }
}
