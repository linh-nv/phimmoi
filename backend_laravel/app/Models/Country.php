<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => Status::class,
    ];

    protected $fillable = [
        'title',
        'slug',
        'description',
        'status',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
