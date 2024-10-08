<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieUser extends Model
{
    use HasFactory;

    protected $table = 'movie_user';

    protected $fillable = [
        'movie_id',
        'user_id',
    ];
}
