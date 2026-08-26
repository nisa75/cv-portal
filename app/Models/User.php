<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Conversation;
use App\Models\Message;
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
         'plan',
         'is_featured',
'featured_until',
];


    protected $hidden = [
        'password',
        'remember_token',
    ];

   protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_featured' => 'boolean',
        'featured_until' => 'datetime',
    ];
}

    public function candidateProfile(): HasOne
    {
        return $this->hasOne(CandidateProfile::class);
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function cvs()
    {
        return $this->hasMany(Cv::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
    public function favorites()
{
    return $this->hasMany(Favorite::class);
}
public function sentMessages()
{
    return $this->hasMany(Message::class, 'sender_id');
}

public function candidateConversations()
{
    return $this->hasMany(Conversation::class, 'candidate_id');
}

public function employerConversations()
{
    return $this->hasMany(Conversation::class, 'employer_id');
}
public function isPremium(): bool
{
    return $this->plan === 'premium';
}

public function isFree(): bool
{
    return $this->plan === 'free';
}
public function isFeatured(): bool
{
    return $this->is_featured
        && $this->featured_until
        && $this->featured_until->isFuture();
}

public function featureForDays(int $days = 7): void
{
    $this->update([
        'is_featured' => true,
        'featured_until' => now()->addDays($days),
    ]);
}

public function removeFeatured(): void
{
    $this->update([
        'is_featured' => false,
        'featured_until' => null,
    ]);
}
}