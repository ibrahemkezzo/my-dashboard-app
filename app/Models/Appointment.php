<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'appointment_number',
        'scheduled_datetime',
        'duration_minutes',
        'total_price',
        'deposit_amount',
        'deposit_paid',
        'payment_status',
        'status',
        'notes',
        'cancellation_reason',
        'cancelled_at',
        'payment_details',
    ];

    protected $casts = [
        'scheduled_datetime' => 'datetime',
        'cancelled_at' => 'datetime',
        'payment_details' => 'array',
        'total_price' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'deposit_paid' => 'decimal:2',
    ];

    /**
     * Get the booking associated with this appointment.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the user through the booking.
     */
    public function user(): BelongsTo
    {
        return $this->booking->user();
    }

    /**
     * Get the salon through the booking.
     */
    public function salon(): BelongsTo
    {
        return $this->booking->salon();
    }

    /**
     * Get the salon sub-service through the booking.
     */
    public function salonSubService(): BelongsTo
    {
        return $this->booking->salonSubService();
    }

    /**
     * Generate a unique appointment number.
     */
    public static function generateAppointmentNumber(): string
    {
        do {
            $number = 'APT' . date('Ymd') . strtoupper(substr(uniqid(), -6));
        } while (static::where('appointment_number', $number)->exists());

        return $number;
    }

    /**
     * Check if the appointment can be cancelled.
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['scheduled', 'in_progress']);
    }

    /**
     * Check if the appointment can be marked as completed.
     */
    public function canBeCompleted(): bool
    {
        return in_array($this->status, ['scheduled', 'in_progress']);
    }

    /**
     * Check if the appointment can be marked as in progress.
     */
    public function canBeInProgress(): bool
    {
        return $this->status === 'scheduled';
    }

    /**
     * Check if payment is required.
     */
    public function isPaymentRequired(): bool
    {
        return $this->deposit_amount > 0 && $this->deposit_paid < $this->deposit_amount;
    }

    /**
     * Check if payment is complete.
     */
    public function isPaymentComplete(): bool
    {
        return $this->deposit_paid >= $this->deposit_amount;
    }

    /**
     * Get the remaining deposit amount.
     */
    public function getRemainingDepositAttribute(): float
    {
        return max(0, $this->deposit_amount - $this->deposit_paid);
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'scheduled' => 'bg-primary',
            'in_progress' => 'bg-info',
            'completed' => 'bg-success',
            'cancelled' => 'bg-danger',
            'no_show' => 'bg-secondary',
            default => 'bg-secondary',
        };
    }

    /**
     * Get the status text.
     */
    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            'scheduled' => __('dashboard.scheduled'),
            'in_progress' => __('dashboard.in_progress'),
            'completed' => __('dashboard.completed'),
            'cancelled' => __('dashboard.cancelled'),
            'no_show' => __('dashboard.no_show'),
            default => __('dashboard.unknown'),
        };
    }

    /**
     * Get the payment status badge class.
     */
    public function getPaymentStatusBadgeClassAttribute(): string
    {
        return match($this->payment_status) {
            'pending' => 'bg-warning',
            'partial' => 'bg-info',
            'paid' => 'bg-success',
            'refunded' => 'bg-secondary',
            default => 'bg-secondary',
        };
    }

    /**
     * Get the payment status text.
     */
    public function getPaymentStatusTextAttribute(): string
    {
        return match($this->payment_status) {
            'pending' => __('dashboard.payment_pending'),
            'partial' => __('dashboard.partial_payment'),
            'paid' => __('dashboard.payment_completed'),
            'refunded' => __('dashboard.payment_refunded'),
            default => __('dashboard.unknown'),
        };
    }

    /**
     * Get the end time of the appointment.
     */
    public function getEndTimeAttribute(): Carbon
    {
        return $this->scheduled_datetime->addMinutes($this->duration_minutes);
    }

    /**
     * Check if the appointment is today.
     */
    public function isToday(): bool
    {
        return $this->scheduled_datetime->isToday();
    }

    /**
     * Check if the appointment is in the past.
     */
    public function isPast(): bool
    {
        return $this->scheduled_datetime->isPast();
    }

    /**
     * Check if the appointment is in the future.
     */
    public function isFuture(): bool
    {
        return $this->scheduled_datetime->isFuture();
    }

    /**
     * Scope to filter by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter by payment status.
     */
    public function scopeByPaymentStatus($query, $paymentStatus)
    {
        return $query->where('payment_status', $paymentStatus);
    }

    /**
     * Scope to filter by date range.
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('scheduled_datetime', [$startDate, $endDate]);
    }

    /**
     * Scope to filter by salon.
     */
    public function scopeBySalon($query, $salonId)
    {
        return $query->whereHas('booking', function ($q) use ($salonId) {
            $q->where('salon_id', $salonId);
        });
    }

    /**
     * Scope to filter by user.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->whereHas('booking', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($appointment) {
            if (empty($appointment->appointment_number)) {
                $appointment->appointment_number = static::generateAppointmentNumber();
            }
        });
    }
} 