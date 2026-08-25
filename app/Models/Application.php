<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Conversation;
use App\Models\Interview;
class Application extends Model
{
    protected $fillable = [
        'user_id',
        'job_post_id',
        'cv_id',
        'cover_letter',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_post_id');
    }

    public function cv(): BelongsTo
    {
        return $this->belongsTo(Cv::class);
    }
    public function conversation()
{
    return $this->hasOne(Conversation::class);
}
public function interview()
{
    return $this->hasOne(Interview::class);
}

}