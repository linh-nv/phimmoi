<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRefreshToken extends Model
{
    use HasFactory;

    protected $fillable = ['token', 'user_id', 'expires_at'];

    public function admin()
    {

        return $this->belongsTo(Admin::class);
    }
}
