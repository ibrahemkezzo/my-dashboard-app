<?php

namespace App\Repositories;

use App\Models\Rating;
use App\Models\User;
use App\Models\Salon;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RatingRepository
{
    /**
     * Get all ratings with pagination.
     */
    public function paginate($perPage = 15, $filters = [])
    {
        $query = Rating::with(['user', 'salon', 'booking']);

        if (isset($filters['status'])) {
            $query->byStatus($filters['status']);
        }

        if (isset($filters['salon_id'])) {
            $query->bySalon($filters['salon_id']);
        }

        if (isset($filters['user_id'])) {
            $query->byUser($filters['user_id']);
        }

        if (isset($filters['rating'])) {
            $query->where('rating', $filters['rating']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Find a rating by ID.
     */
    public function find($id)
    {
        return Rating::with(['user', 'salon', 'booking'])->find($id);
    }

    /**
     * Create a new rating.
     */
    public function create(array $data)
    {
        return Rating::create($data);
    }

    /**
     * Update an existing rating.
     */
    public function update(Rating $rating, array $data)
    {
        $rating->update($data);
        return $rating;
    }

    /**
     * Delete a rating.
     */
    public function delete(Rating $rating)
    {
        return $rating->delete();
    }

    /**
     * Get ratings by salon with pagination.
     */
    public function getBySalon(Salon $salon, $perPage = 15, $filters = [])
    {
        $query = $salon->ratings()->with(['user', 'booking']);

        if (isset($filters['status'])) {
            $query->byStatus($filters['status']);
        }

        if (isset($filters['rating'])) {
            $query->where('rating', $filters['rating']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get ratings by user with pagination.
     */
    public function getByUser(User $user, $perPage = 15, $filters = [])
    {
        $query = $user->ratings()->with(['salon', 'booking']);

        if (isset($filters['status'])) {
            $query->byStatus($filters['status']);
        }

        if (isset($filters['salon_id'])) {
            $query->bySalon($filters['salon_id']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Check if user has already rated a salon.
     */
    public function userHasRatedSalon(User $user, Salon $salon): bool
    {
        return $user->ratings()->where('salon_id', $salon->id)->exists();
    }

    /**
     * Get average rating for a salon.
     */
    public function getAverageRatingForSalon(Salon $salon): float
    {
        return $salon->ratings()
            ->where('status', 'approved')
            ->avg('rating') ?? 0.0;
    }

    /**
     * Get rating count for a salon.
     */
    public function getRatingCountForSalon(Salon $salon): int
    {
        return $salon->ratings()
            ->where('status', 'approved')
            ->count();
    }

    /**
     * Get rating distribution for a salon.
     */
    public function getRatingDistributionForSalon(Salon $salon): array
    {
        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $distribution[$i] = $salon->ratings()
                ->where('status', 'approved')
                ->where('rating', $i)
                ->count();
        }
        return $distribution;
    }

    /**
     * Get pending ratings count.
     */
    public function getPendingRatingsCount(): int
    {
        return Rating::byStatus('pending')->count();
    }

    /**
     * Get recent ratings.
     */
    public function getRecent($limit = 10, $filters = [])
    {
        $query = Rating::with(['user', 'salon', 'booking']);

        if (isset($filters['status'])) {
            $query->byStatus($filters['status']);
        }

        return $query->orderBy('created_at', 'desc')->limit($limit)->get();
    }
}
