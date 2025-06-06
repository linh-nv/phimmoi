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
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
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

    public function movie(): BelongsTo
    {

        return $this->belongsTo(related: Movie::class, foreignKey: 'movie_id', ownerKey: 'id');
    }

    public function user(): BelongsTo
    {

        return $this->belongsTo(related: User::class, foreignKey: 'user_id', ownerKey: 'id');
    }

    public function episode(): BelongsTo
    {
        return $this->belongsTo(related: Episode::class, foreignKey: 'episode_id', ownerKey: 'id');
    }
}
