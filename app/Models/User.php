<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'avatar',
        'bio',
        'location',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get all posts by this user
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get published posts by this user
     */
    public function publishedPosts(): HasMany
    {
        return $this->hasMany(Post::class)
                   ->where('status', 'published')
                   ->whereNotNull('published_at')
                   ->orderBy('published_at', 'desc');
    }

    /**
     * Get the user's avatar URL or default
     */
    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar 
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=6366f1&color=white';
    }

    /**
     * Get user's full profile URL
     */
    public function getProfileUrlAttribute(): string
    {
        return route('user.profile', $this->username);
    }
}