<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'country',
        'google_place_id',
        'timezone',
        'is_active',
    ];


    public function users()
    {
        return $this->hasMany(User::class, 'city_id', 'id');
    }

}