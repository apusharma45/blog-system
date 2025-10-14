<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'read_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    public function markAsRead(): void
    {
        $this->update(['read_at' => now()]);
    }

    public function isRead(): bool
    {
        return !is_null($this->read_at);
    }

    public static function createForUser($userId, $type, $notifiableType, $notifiableId, $data = [])
    {
        return static::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'user_id' => $userId,
            'type' => $type,
            'notifiable_type' => $notifiableType,
            'notifiable_id' => $notifiableId,
            'data' => $data,
        ]);
    }

    public function getTitleAttribute(): string
    {
        return $this->data['title'] ?? $this->getDefaultTitle();
    }

    public function getMessageAttribute(): string
    {
        return $this->data['message'] ?? $this->getDefaultMessage();
    }

    private function getDefaultTitle(): string
    {
        return match($this->type) {
            'like' => 'New Like',
            'comment' => 'New Comment',
            'follow' => 'New Follower',
            default => 'Notification'
        };
    }

    private function getDefaultMessage(): string
    {
        return match($this->type) {
            'like' => 'Someone liked your post',
            'comment' => 'Someone commented on your post',
            'follow' => 'Someone started following you',
            default => 'You have a new notification'
        };
    }
}


