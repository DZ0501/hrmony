<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferenceKey extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'description'];
    public $timestamps = false;
}
