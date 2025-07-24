<?php

namespace App\Repositories;

use App\Models\Salon;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class FavoriteRepository
{
    public function toggleFavorite(User $user, int $salonId)
    {
        $salon = Salon::findOrFail($salonId);
        return $user->favoriteSalons()->toggle($salonId);
    }

    public function getFavoriteSalons(User $user): Collection
    {
        return $user->favoriteSalons()->with(['city', 'subServices'])->get();
    }

    public function isFavorite(User $user, int $salonId): bool
    {
        return $user->favoriteSalons()->where('salon_id', $salonId)->exists();
    }
}