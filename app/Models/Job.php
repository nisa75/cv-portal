<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{
    protected $table = 'job_posts';
    protected $fillable = [
        'company_id',
        'title',
        'department',
        'employment_type',
        'location',
        'salary_min',
        'salary_max',
        'experience_level',
        'education_level',
        'description',
        'skills',
        'benefits',
        'deadline',
        'status',
    ];

    protected $casts = [
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
        'deadline' => 'date',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
   public function applications()
{
    return $this->hasMany(Application::class, 'job_post_id');
} 
public function favorites()
{
    return $this->hasMany(Favorite::class, 'job_post_id');
}
}