<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieView extends Model
{
    use HasFactory;

    protected $table = 'movie_view';

    protected $fillable = [
        'movie_id',
        'viewed_at',
    ];
}
