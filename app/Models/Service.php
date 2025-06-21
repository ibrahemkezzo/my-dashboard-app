<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name', 'short_description', 'long_description',
        'icon_or_image', 'custom_url', 'order', 'status', 'seo_meta',
    ];

    protected $casts = [
        'seo_meta' => 'array',
        'status' => 'boolean',
    ];
}
