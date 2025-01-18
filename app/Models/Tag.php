<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function requirements()
    {
        return $this->belongsToMany(Requirement::class, 'requirement_tag');
    }

    public function responsibilities()
    {
        return $this->belongsToMany(Responsibility::class, 'responsibility_tag');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_tag');
    }
}
