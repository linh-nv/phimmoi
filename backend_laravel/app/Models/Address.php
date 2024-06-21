<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'province_id',
        'district_id',
        'ward_id'
    ];

    public function province()
    {

        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }
    
    public function district()
    {

        return $this->belongsTo(District::class, 'district_id', 'district_id');
    }
    
    public function ward()
    {

        return $this->belongsTo(Ward::class, 'ward_id', 'ward_id');
    }
}
