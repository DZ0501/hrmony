<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    protected $fillable = ['name'];

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'position_requirement');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'requirement_tag');
    }

}
