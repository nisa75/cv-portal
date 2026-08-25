<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidateProfile extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'city',
        'about',
        'profile_photo',
        'github',
        'linkedin',
        'portfolio',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}