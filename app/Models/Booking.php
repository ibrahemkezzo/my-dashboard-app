<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'salon_id',
        'salon_sub_service_id',
        'booking_number',
        'service_description',
        'preferred_datetime',
        'status',
        'rejection_reason',
        'salon_confirmed_datetime',
        'user_confirmed_datetime',
        'salon_proposed_datetime',
        'salon_proposed_price',
        'salon_proposed_duration',
        'salon_notes',
        'salon_modification_reason',
        'additional_data',
    ];

    protected $casts = [
        'preferred_datetime' => 'datetime',
        'salon_confirmed_datetime' => 'datetime',
        'user_confirmed_datetime' => 'datetime',
        'salon_proposed_datetime' => 'datetime',
        'salon_proposed_price' => 'decimal:2',
        'additional_data' => 'array',
    ];

    /**
     * Get the user who made the booking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the salon where the booking was made.
     */
    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }

    /**
     * Get the salon sub-service for this booking.
     */
    public function salonSubService(): BelongsTo
    {
        return $this->belongsTo(SalonSubService::class, 'salon_sub_service_id');
    }

    /**
     * Get the appointment associated with this booking.
     */
    public function appointment(): HasOne
    {
        return $this->hasOne(Appointment::class);
    }

    /**
     * Get the rating for this booking.
     */
    public function rating()
    {
        return $this->hasOne(Rating::class);
    }



    /**
     * Generate a unique booking number.
     */
    public static function generateBookingNumber(): string
    {
        do {
            $number = 'BK' . date('Ymd') . strtoupper(substr(uniqid(), -6));
        } while (static::where('booking_number', $number)->exists());

        return $number;
    }

    /**
     * Check if the booking can be confirmed by salon.
     */
    public function canBeConfirmedBySalon(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the booking can be confirmed by user.
     */
    public function canBeConfirmedByUser(): bool
    {
        return $this->status === 'salon_confirmed';
    }

    /**
     * Check if the booking can be rejected.
     */
    public function canBeRejected(): bool
    {
        return in_array($this->status, ['pending', 'salon_confirmed']);
    }

    /**
     * Check if the booking can be cancelled.
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'salon_confirmed', 'user_confirmed']);
    }

    /**
     * Check if salon has modified the booking.
     */
    public function isModifiedBySalon(): bool
    {
        return $this->salon_proposed_datetime &&
               $this->salon_proposed_datetime->ne($this->preferred_datetime);
    }

    /**
     * Get the final appointment datetime (salon proposed or user preferred).
     */
    public function getFinalDatetimeAttribute(): Carbon
    {
        return $this->salon_proposed_datetime ?? $this->preferred_datetime;
    }

    /**
     * Get the final price (salon proposed or service price).
     */
    public function getFinalPriceAttribute(): float
    {
        return $this->salon_proposed_price ?? $this->salonSubService->price ?? 0;
    }

    /**
     * Get the final duration (salon proposed or service duration).
     */
    public function getFinalDurationAttribute(): int
    {
        return $this->salon_proposed_duration ?? $this->salonSubService->duration ?? 60;
    }

    /**
     * Check if the booking can be completed.
     */
    public function canBeCompleted(): bool
    {
        return in_array($this->status, ['user_confirmed']);
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'pending' => 'bg-warning',
            'salon_confirmed' => 'bg-info',
            'user_confirmed' => 'bg-success',
            'completed' => 'bg-secondary',
            'rejected' => 'bg-danger',
            'cancelled' => 'bg-primary',
            default => 'bg-secondary',
        };
    }

    /**
     * Get the status text.
     */
    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            'pending' => __('dashboard.pending'),
            'salon_confirmed' => __('dashboard.salon_confirmed'),
            'user_confirmed' => __('dashboard.user_confirmed'),
            'completed' => __('dashboard.completed'),
            'rejected' => __('dashboard.rejected'),
            'cancelled' => __('dashboard.cancelled'),
            default => __('dashboard.unknown'),
        };
    }

    /**
     * Scope to filter by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter by salon.
     */
    public function scopeBySalon($query, $salonId)
    {
        return $query->where('salon_id', $salonId);
    }

    /**
     * Scope to filter by user.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to filter by date range.
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('preferred_datetime', [$startDate, $endDate]);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_number)) {
                $booking->booking_number = static::generateBookingNumber();
            }
        });
    }
}
