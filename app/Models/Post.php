<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'excerpt',
        'status',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    /**
     * Boot the model to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = static::generateUniqueSlug($post->title);
            }
            
            // Auto-generate excerpt if not provided
            if (empty($post->excerpt) && !empty($post->content)) {
                $post->excerpt = Str::limit(strip_tags($post->content), 200);
            }
        });

        static::updating(function ($post) {
            // Update slug if title changed
            if ($post->isDirty('title')) {
                $post->slug = static::generateUniqueSlug($post->title, $post->id);
            }
            
            // Auto-update excerpt if content changed and excerpt is empty
            if ($post->isDirty('content') && empty($post->excerpt)) {
                $post->excerpt = Str::limit(strip_tags($post->content), 200);
            }
        });
    }

    /**
     * Generate a unique slug for the post
     */
    public static function generateUniqueSlug($title, $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        $query = static::where('slug', $slug);
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
            $query = static::where('slug', $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
        }

        return $slug;
    }

    /**
     * Get the post's author
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for published posts only
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope for draft posts only
     */
    public function scopeDrafts($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Check if post is published
     */
    public function getIsPublishedAttribute(): bool
    {
        return $this->status === 'published' 
               && $this->published_at 
               && $this->published_at->lte(now());
    }

    /**
     * Get the post's full URL
     */
    public function getUrlAttribute(): string
    {
        return route('posts.show', [
            'username' => $this->user->username,
            'slug' => $this->slug
        ]);
    }

    /**
     * Publish the post
     */
    public function publish(): void
    {
        $this->update([
            'status' => 'published',
            'published_at' => $this->published_at ?? now(),
        ]);
    }

    /**
     * Unpublish the post (make it draft)
     */
    public function unpublish(): void
    {
        $this->update([
            'status' => 'draft',
            'published_at' => null,
        ]);
    }
}