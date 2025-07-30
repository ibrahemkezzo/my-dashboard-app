<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function sub_services()
    {
        return $this->hasMany(SubService::class);
    }
}
