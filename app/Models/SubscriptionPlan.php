<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'duration_days', 'is_active'];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
