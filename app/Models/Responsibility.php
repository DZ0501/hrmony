<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsibility extends Model
{
    protected $fillable = ['name'];

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'position_responsibility');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'responsibility_tag');
    }

}
