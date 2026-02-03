<?php

namespace App\Repositories;

use App\Contracts\SubscriptionRepositoryInterface;
use App\Models\Salon;
use App\Models\Subscription;
use Illuminate\Support\Collection;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    public function createForSalon(Salon $salon, array $data): Subscription
    {
        return $salon->subscription()->create($data);
    }

    public function findBySalon(Salon $salon): ?Subscription
    {
        return $salon->subscription;
    }

    public function findNeedingReminders(): Collection
    {
        return Subscription::where('status', 'active')
            ->whereRaw('DATEDIFF(end_date, NOW()) = 5')
            ->get();
    }

    public function findExpired(): Collection
    {
        return Subscription::where('end_date', '<', now())
            ->where('status', '!=', 'expired')
            ->get();
    }
}
