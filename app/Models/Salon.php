<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Salon extends Model
{
    protected $fillable = [
        'name', 'description', 'address', 'phone', 'email', 'owner_id', 'city_id',
        'status', 'working_hours', 'rating', 'logo', 'cover_image', 'social_links', 'seo_meta',
    ];

    protected $casts = [
        'working_hours' => 'array',
        'social_links' => 'array',
        'seo_meta' => 'array',
        'status' => 'boolean',
        'rating' => 'decimal:2',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function subServices(): BelongsToMany
    {
        return $this->belongsToMany(SubService::class, 'salon_sub_service')
            ->using(SalonSubService::class)
            ->withPivot(['id', 'price', 'duration', 'materials_used', 'requirements', 'special_notes', 'status'])
            ->withTimestamps();
    }

    public function media()
    {
        return $this->morphMany(\App\Models\Media::class, 'mediable');
    }

    /**
     * Get the bookings for this salon.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the appointments for this salon.
     */
    public function appointments()
    {
        return $this->hasManyThrough(Appointment::class, Booking::class);
    }
}