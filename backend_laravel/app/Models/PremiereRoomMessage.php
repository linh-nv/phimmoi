<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PremiereRoomMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'premiere_room_code',
        'user_id',
        'message',
        'type',
        'metadata',
        'is_deleted',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_deleted' => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
        'is_deleted',
    ];

    protected $appends = [
        'formatted_time',
        'user_name',
        'user_avatar',
    ];

    /**
     * Relationship với PremiereRoom
     */
    public function premiereRoom(): BelongsTo
    {
        return $this->belongsTo(PremiereRoom::class, 'premiere_room_code', 'code');
    }

    /**
     * Relationship với User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor cho formatted time
     */
    public function getFormattedTimeAttribute(): string
    {
        return $this->created_at->format('H:i');
    }

    /**
     * Accessor cho user name
     */
    public function getUserNameAttribute(): ?string
    {
        return $this->user?->name;
    }

    /**
     * Accessor cho user avatar
     */
    public function getUserAvatarAttribute(): ?string
    {
        return $this->user?->avatar;
    }

    /**
     * Scope để lấy tin nhắn chưa bị xóa
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('is_deleted', false);
    }

    /**
     * Scope để lấy tin nhắn theo phòng
     */
    public function scopeByRoom($query, string $roomCode)
    {
        return $query->where('premiere_room_code', $roomCode);
    }

    /**
     * Scope để lấy tin nhắn mới nhất
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope để lấy tin nhắn cũ nhất
     */
    public function scopeOldest($query)
    {
        return $query->orderBy('created_at', 'asc');
    }

    /**
     * Method để xóa mềm tin nhắn
     */
    public function softDeleteMessage(): bool
    {
        return $this->update([
            'is_deleted' => true,
            'deleted_at' => now(),
        ]);
    }

    /**
     * Method để khôi phục tin nhắn
     */
    public function restoreMessage(): bool
    {
        return $this->update([
            'is_deleted' => false,
            'deleted_at' => null,
        ]);
    }
}
