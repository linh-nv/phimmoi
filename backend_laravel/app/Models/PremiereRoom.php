<?php

namespace App\Models;

use App\Enums\MovieQuality;
use App\Enums\MovieStatus;
use App\Enums\MovieType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PremiereRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'movie_id',
        'episode_id',
        'title',
        'isPublic',
        'user_id',
    ];

    protected $casts = [
        'isPublic' => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $appends = [
        'online_users_count',
        'total_messages_count',
        'last_activity',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->code)) {
                $model->code = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'code';
    }

    /**
     * Relationship với Movie
     */
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class, 'movie_id', 'id');
    }

    /**
     * Relationship với User (chủ phòng)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relationship với Episode
     */
    public function episode(): BelongsTo
    {
        return $this->belongsTo(Episode::class, 'episode_id', 'id');
    }

    /**
     * Relationship với Messages
     */
    public function messages(): HasMany
    {
        return $this->hasMany(PremiereRoomMessage::class, 'premiere_room_code', 'code');
    }

    /**
     * Relationship với Messages (chưa bị xóa)
     */
    public function activeMessages(): HasMany
    {
        return $this->messages()->notDeleted();
    }

    /**
     * Relationship với Messages (mới nhất)
     */
    public function latestMessages(): HasMany
    {
        return $this->activeMessages()->latest();
    }

    /**
     * Accessor cho số người online (sẽ được tính từ Pusher/Redis)
     */
    public function getOnlineUsersCountAttribute(): int
    {
        // Tạm thời return 0, sẽ implement sau với Pusher presence
        return 0;
    }

    /**
     * Accessor cho tổng số tin nhắn
     */
    public function getTotalMessagesCountAttribute(): int
    {
        return $this->activeMessages()->count();
    }

    /**
     * Accessor cho hoạt động cuối cùng
     */
    public function getLastActivityAttribute(): ?string
    {
        $lastMessage = $this->messages()->latest()->first();
        return $lastMessage?->created_at?->diffForHumans();
    }

    /**
     * Scope để tìm phòng public
     */
    public function scopePublic($query)
    {
        return $query->where('isPublic', true);
    }

    /**
     * Scope để tìm phòng private
     */
    public function scopePrivate($query)
    {
        return $query->where('isPublic', false);
    }

    /**
     * Scope để tìm phòng của user
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Method để lấy channel name cho broadcasting
     */
    public function getBroadcastChannelName(): string
    {
        return "chat-room.{$this->code}";
    }

    /**
     * Method để kiểm tra user có quyền truy cập phòng không
     */
    public function canAccess(?User $user = null): bool
    {
        if ($this->isPublic) {
            return true;
        }

        if (!$user) {
            return false;
        }

        // Chủ phòng luôn có quyền truy cập
        return $this->user_id === $user->id;
    }

    /**
     * Method để kiểm tra user có quyền quản lý phòng không
     */
    public function canManage(?User $user = null): bool
    {
        if (!$user) {
            return false;
        }

        return $this->user_id === $user->id;
    }
}
