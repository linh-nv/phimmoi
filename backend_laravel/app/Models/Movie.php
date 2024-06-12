<?php

namespace App\Models;

use App\Enums\MovieStatus;
use App\Enums\MovieType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $casts = [
        'type' => MovieType::class,
        'status' => MovieStatus::class,
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

    public function genre()
    {

        return $this->belongsToMany(Genre::class, 'movie_genre', 'movie_id', 'genre_id');
    }

    public function country()
    {

        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
