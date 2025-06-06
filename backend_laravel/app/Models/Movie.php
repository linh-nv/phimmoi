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

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'origin_name',
        'content',
        'type',
        'status',
        'poster_url',
        'thumb_url',
        'is_copyright',
        'sub_docquyen',
        'chieurap',
        'trailer_url',
        'time',
        'episode_current',
        'episode_total',
        'quality',
        'lang',
        'notify',
        'showtimes',
        'year',
        'view',
        'actor',
        'director',
        'country_id',
        'category_id',
    ];

    protected $casts = [
        'type' => MovieType::class,
        'status' => MovieStatus::class,
        'quality' => MovieQuality::class,
        'is_copyright' => 'boolean',
        'sub_docquyen' => 'boolean',
        'chieurap' => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {

        return $this->belongsTo(related: Category::class, foreignKey: 'category_id', ownerKey: 'id');
    }

    public function genres(): BelongsToMany
    {

        return $this->belongsToMany(related: Genre::class, table: 'movie_genre', foreignPivotKey: 'movie_id', relatedPivotKey: 'genre_id');
    }

    public function country(): BelongsTo
    {

        return $this->belongsTo(related: Country::class, foreignKey: 'country_id', ownerKey: 'id');
    }

    public function episodes(): HasMany
    {
        return $this->hasMany(Episode::class, foreignKey: 'movie_slug', localKey: 'slug')
            ->orderByRaw("CAST(REGEXP_SUBSTR(name, '[0-9]+') AS UNSIGNED)");
    }

    public function comments(): HasMany
    {
        return $this->hasMany(related: MovieComment::class);
    }
}
