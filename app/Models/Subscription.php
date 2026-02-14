<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'salon_id', 'subscription_plan_id', 'start_date', 'end_date', 'status', 'payment_token'
    ];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];

    public function salon()
    {
        return $this->belongsTo(Salon::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function histories()
    {
        return $this->hasMany(SubscriptionHistory::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && Carbon::now()->lte($this->end_date);
    }

    public function extend(int $days): void
    {
        $this->end_date = $this->end_date ? $this->end_date->addDays($days) : Carbon::now()->addDays($days);
        $this->status = 'active';
        $this->save();
    }

    public function needsReminder(): bool
    {
        return $this->end_date && Carbon::now()->diffInDays($this->end_date) === 5 && $this->status === 'active';
    }
}
