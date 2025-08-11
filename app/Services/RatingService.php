<?php

namespace App\Services;

use App\Models\Rating;
use App\Models\User;
use App\Models\Salon;
use App\Repositories\RatingRepository;
use Illuminate\Support\Facades\DB;
use Exception;

class RatingService
{
    public function __construct(
        private RatingRepository $ratingRepository
    ) {}

    /**
     * Upsert a rating for a salon by a user.
     * - Creates if not exists, updates otherwise
     * - Requires at least one completed booking with the salon
     */
    public function saveRating(User $user, Salon $salon, array $data): Rating
    {
        // Ensure user is eligible (at least one completed booking)
        if (!$this->canUserRateSalon($user, $salon)) {
            throw new Exception('You are not eligible to rate this salon.');
        }

        return DB::transaction(function () use ($user, $salon, $data) {
            $existing = $user->ratings()->where('salon_id', $salon->id)->first();

            if ($existing) {
                $existing->rating = (int) ($data['rating'] ?? $existing->rating);
                $existing->review = $data['review'] ?? $existing->review;
                // Optional: send back to pending moderation on update
                $existing->status = 'pending';
                $existing->save();
                $this->updateSalonRating($salon);
                return $existing;
            }

            $created = $this->ratingRepository->create([
                'user_id' => $user->id,
                'salon_id' => $salon->id,
                'rating' => (int) $data['rating'],
                'review' => $data['review'] ?? null,
                'status' => 'pending',
            ]);
            $this->updateSalonRating($salon);
            return $created;
        });
    }

    /**
     * Used by dashboard: update a rating fields (rating, review, status)
     */
    public function updateRating(Rating $rating, array $data): Rating
    {
        $rating->fill([
            'rating' => isset($data['rating']) ? (int)$data['rating'] : $rating->rating,
            'review' => $data['review'] ?? $rating->review,
            'status' => $data['status'] ?? $rating->status,
        ]);
        $rating->save();
        $this->updateSalonRating($rating->salon);
        return $rating;
    }

    /**
     * Used by dashboard: delete a rating
     */
    public function deleteRating(Rating $rating): bool
    {
        $salon = $rating->salon;
        $deleted = (bool)$rating->delete();
        if ($deleted) {
            $this->updateSalonRating($salon);
        }
        return $deleted;
    }

    /**
     * Check if user can rate a salon (has at least one completed booking there)
     */
    public function canUserRateSalon(User $user, Salon $salon): bool
    {
        return $user->bookings()
            ->where('salon_id', $salon->id)
            ->where('status', 'completed')
            ->exists();
    }

    /**
     * Update salon's average rating (approved only)
     */
    private function updateSalonRating(Salon $salon): void
    {
        $averageRating = $this->ratingRepository->getAverageRatingForSalon($salon);
        $salon->update(['rating' => round($averageRating, 2)]);
    }

    public function getSalonRatings(Salon $salon, $perPage = 15, $filters = [])
    {
        return $this->ratingRepository->getBySalon($salon, $perPage, $filters);
    }

    public function getUserRatings(User $user, $perPage = 15, $filters = [])
    {
        return $this->ratingRepository->getByUser($user, $perPage, $filters);
    }

    public function getAllRatings($perPage = 15, $filters = [])
    {
        return $this->ratingRepository->paginate($perPage, $filters);
    }

    public function approveRating(Rating $rating): Rating
    {
        $rating->status = 'approved';
        $rating->save();
        $this->updateSalonRating($rating->salon);
        return $rating;
    }

    public function rejectRating(Rating $rating, string $reason = null): Rating
    {
        $rating->status = 'rejected';
        $rating->save();
        $this->updateSalonRating($rating->salon);
        return $rating;
    }

    public function getSalonRatingStatistics(Salon $salon): array
    {
        return [
            'average_rating' => $this->ratingRepository->getAverageRatingForSalon($salon),
            'total_ratings' => $this->ratingRepository->getRatingCountForSalon($salon),
            'rating_distribution' => $this->ratingRepository->getRatingDistributionForSalon($salon),
        ];
    }

    public function getPendingRatingsCount(): int
    {
        return $this->ratingRepository->getPendingRatingsCount();
    }

    public function getRecentRatings($limit = 10, $filters = [])
    {
        return $this->ratingRepository->getRecent($limit, $filters);
    }
}
