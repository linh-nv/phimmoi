<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MovieComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'user_id',
        'comment',
        'parent_id',
    ];

    public function movie(): BelongsTo
    {
        return $this->belongsTo(related: Movie::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(related: User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(related: MovieComment::class, foreignKey: 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(related: MovieComment::class, foreignKey: 'parent_id');
    }
}
