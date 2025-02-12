<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'published',
        'created_by',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'company_update_tag');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
