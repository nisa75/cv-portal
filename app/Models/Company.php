<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'logo',
        'description',
        'industry',
        'location',
        'website',
        'linkedin',
        'instagram',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function jobs()
{
    return $this->hasMany(Job::class);
}
}