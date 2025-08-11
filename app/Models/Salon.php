<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

class Salon extends Model
{
    protected $fillable = [
        'name', 'description', 'address', 'phone', 'email', 'owner_id', 'city_id',
        'status', 'working_hours', 'rating', 'logo', 'cover_image', 'social_links', 'seo_meta','features' ,'type',
        'longitude','latitude',
        'license_document','license_start_date', 'license_end_date', 'hasOffer', 'offer','is_promoted'
    ];

    protected $casts = [
        'working_hours' => 'array',
        'social_links' => 'array',
        'features' => 'array',
        'seo_meta' => 'array',
        'status' => 'boolean',
        'rating' => 'decimal:2',
    ];

    protected $appends = ['cover_image_url','logo_url' , 'is_open' , 'is_favorited','license_url','review_count'];

    /**
     * The owner of the salon (one-to-one with User).
     */
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
        return $this->morphMany(Media::class, 'mediable');
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

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorite_salons', 'salon_id', 'user_id')
                    ->withTimestamps();
    }

    /**
     * Get the ratings for this salon.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Accessor to check if the salon is favorited by the current user.
     *
     * @return bool
     */
    public function getReviewCountAttribute()
    {
        return $this->ratings()->where('status','approved')->count();;
    }
    /**
     * Accessor to check if the salon is favorited by the current user.
     *
     * @return bool
     */
    public function getIsFavoritedAttribute()
    {
        return Auth::check() ? $this->favoritedByUsers->contains(Auth::id()) : false;
    }
    /**
     * Get the price range for the salon's services.
     *
     * @return array|null [min, max] or null if no prices
     */
    public function getPriceRangeAttribute()
    {
        $prices = $this->subServices->pluck('pivot.price')->filter(function ($price) {
            return !is_null($price);
        });
        if ($prices->isEmpty()) {
            return null;
        }
        return [
            'min' => $prices->min(),
            'max' => $prices->max(),
        ];
    }

    /**
     * Get the full URL for the cover image.
     */
    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image ? asset('storage/' . $this->cover_image) : null;
    }

    /**
     * Get the full URL for the logo image.
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }
    /**
     * Get the full URL for the logo image.
     */
    public function getLicenseUrlAttribute()
    {
        return $this->license_document ? asset('storage/' . $this->license_document) : null;
    }

    /**
     * Get the best image URL (cover, then logo, then null).
     */
    public function getImageUrlAttribute()
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        } elseif ($this->logo) {
            return asset('storage/' . $this->logo);
        }
        return null;
    }

    /**
     * Determine if the salon is open based on working hours.
     *
     * @return bool
     */
    public function getIsOpenAttribute()
    {
        // Set timezone explicitly (optional, as Laravel's config/app.php timezone is used by default)
        $timezone = config('app.timezone', 'Asia/Riyadh'); // Fallback to Asia/Riyadh if not set


        // Get current day (in lowercase to match array keys) and current time
        $currentDay = strtolower(Carbon::now($timezone)->englishDayOfWeek);
        $currentTime = Carbon::now($timezone)->format('H:i');

        // Check if salon hours exist for the current day
        $isOpen = false;
        if (isset($this->working_hours[$currentDay])) {
            $dayHours = $this->working_hours[$currentDay];

            // If 'closed' is 'on', salon is closed all day
            if (isset($dayHours['closed']) && $dayHours['closed'] === 'on') {
                $isOpen = false;
            } else {
                // Compare current time with open and close times
                $openTime = $dayHours['open'];
                $closeTime = $dayHours['close'];

                // Handle cases where close time is past midnight
                $current = Carbon::today()
                    ->addHours((int) substr($currentTime, 0, 2))
                    ->addMinutes((int) substr($currentTime, 3, 2));

                $open = Carbon::today()
                    ->addHours((int) substr($openTime, 0, 2))
                    ->addMinutes((int) substr($openTime, 3, 2));
                $close = Carbon::today()
                    ->addHours((int) substr($closeTime, 0, 2))
                    ->addMinutes((int) substr($closeTime, 3, 2));

                // If close time is before open time, it means it extends to the next day
                if ($close < $open) {
                    $close->addDay();
                }

                // Check if current time is between open and close times
                $isOpen = $current->between($open, $close);
            }
        }

        return $isOpen;
    }
}
