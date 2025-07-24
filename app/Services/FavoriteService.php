<?php

namespace App\Services;

use App\Repositories\FavoriteRepository;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Response;

class FavoriteService
{
    protected $favoriteRepository;

    public function __construct(FavoriteRepository $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

    public function toggleFavorite(User $user, int $salonId)
    {
        $result = $this->favoriteRepository->toggleFavorite($user, $salonId);
        $isFavorited = $this->favoriteRepository->isFavorite($user, $salonId);
        // dd($salonId);
        return [
            'success' => true,
            'is_favorited' => $isFavorited,
            'message' => $isFavorited ? 'تمت إضافة الصالون إلى المفضلة.' : 'تمت إزالة الصالون من المفضلة.',
        ];
    }

    public function getFavoriteSalons(User $user): Collection
    {
        return $this->favoriteRepository->getFavoriteSalons($user);
    }
}