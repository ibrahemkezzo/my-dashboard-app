<?php

namespace App\Services;

use App\Models\Reward;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class RewardService
{
    /**
     * Get all rewards with optional filtering and pagination.
     *
     * @param array $filters
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAllRewards(array $filters = [], int $perPage = 10)
    {
        $query = Reward::query();

        // تصفية حسب الوصف إذا وُجد
        if (!empty($filters['description'])) {
            $query->where('description', 'like', '%' . $filters['description'] . '%');
        }

        // تصفية حسب النقاط المطلوبة إذا وُجد
        if (!empty($filters['required_points'])) {
            $query->where('required_points', $filters['required_points']);
        }

        return $query->paginate($perPage);
    }

    /**
     * Create a new reward.
     *
     * @param array $data
     * @return Reward
     */
    public function createReward(array $data): Reward
    {
        return Reward::create($data);
    }

    /**
     * Update an existing reward.
     *
     * @param Reward $reward
     * @param array $data
     * @return Reward
     */
    public function updateReward(Reward $reward, array $data): Reward
    {
        $reward->update($data);
        return $reward;
    }


    /**
     * Delete a reward softly.
     *
     * @param Reward $reward
     * @return void
     */
    public function deleteReward(Reward $reward): void
    {
        $reward->delete();
    }

    /**
     * Get the current points per booking setting.
     *
     * @return int
     */
    public function getPointsPerBooking(): int
    {
        return (int) Setting::where('key', 'points_per_booking')->first()->value ?? 5;
    }

    /**
     * Update the points per booking setting.
     *
     * @param array $data
     * @return void
     */
    public function updatePointsPerBooking(array $data): void
    {
        Setting::updateOrCreate(
            ['key' => 'points_per_booking'],
            ['value' => $data['points_per_booking']]
        );
    }
}
