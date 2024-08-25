<?php

namespace App\Models;

use App\Enums\MovieQuality;
use App\Enums\MovieStatus;
use App\Enums\MovieType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category()
    {

        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function genres()
    {

        return $this->belongsToMany(Genre::class, 'movie_genre', 'movie_id', 'genre_id');
    }

    public function country()
    {

        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function episodes()
    {

        return $this->hasMany(Episode::class, 'movie_slug', 'slug');
    }
}
