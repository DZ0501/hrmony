<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Request extends Model
{
    use HasFactory;

    protected $table = 'requests';

    protected $fillable = ['user_id', 'type', 'details', 'status'];

    protected $casts = [
        'details' => 'array', // Automatically converts JSON to array
    ];

    /**
     * Get the user who submitted the request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
