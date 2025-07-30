<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubService extends Model
{
    protected $fillable = [
        'service_id', 'name', 'description', 'order', 'status', 'icon_or_image', 'seo_meta',
    ];

    protected $casts = [
        'seo_meta' => 'array',
        'status' => 'boolean',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function salons()
    {
        return $this->belongsToMany(Salon::class, 'salon_sub_service')
            ->using(SalonSubService::class)
            ->withPivot(['price', 'duration', 'materials_used', 'requirements', 'special_notes', 'status'])
            ->withTimestamps();
    }
}
