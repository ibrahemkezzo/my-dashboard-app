<?php

namespace App\Contracts;

use App\Models\Salon;
use App\Models\Subscription;
use Illuminate\Support\Collection;

interface SubscriptionRepositoryInterface
{
    public function createForSalon(Salon $salon, array $data): Subscription;
    public function findBySalon(Salon $salon): ?Subscription;
    public function findNeedingReminders(): Collection;
    public function findExpired(): Collection;
}
