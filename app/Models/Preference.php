<?php

namespace App\Models;

use App\Enums\UserPreferenceKey;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'preference_user')
            ->withPivot('value');
    }

    public function getEnum(): ?UserPreferenceKey
    {
        return UserPreferenceKey::tryFrom($this->name);
    }
}

