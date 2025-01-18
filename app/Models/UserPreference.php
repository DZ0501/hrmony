<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'key', 'value'];

    public function preferenceKey()
    {
        return $this->belongsTo(PreferenceKey::class, 'key', 'key');
    }
}
