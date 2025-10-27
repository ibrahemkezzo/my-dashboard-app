<?php

namespace App\Services;

use App\Models\Reward;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserReward;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRewardService
{

    /**
     * جلب عدد النقاط لكل حجز من الإعدادات
     */
    public function getPointsPerBooking(): int
    {
        return (int) Setting::where('key', 'points_per_booking')->value('value') ?? 5;
    }

    /**
     * Get all user rewards with optional filtering and pagination.
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllUserRewards(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = UserReward::with(['user', 'reward']);

        // Filter by user name if provided
        if (!empty($filters['user_name'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['user_name'] . '%');
            });
        }

        // Filter by status if provided
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        $query->orderByDesc('created_at');

        return $query->paginate($perPage);
    }

    /**
     * Update the status of a user reward.
     *
     * @param UserReward $userReward
     * @param array $data
     * @return UserReward
     */
    public function updateStatus(UserReward $userReward, array $data): UserReward
    {
        $userReward->update(['status' => $data['status']]);
        return $userReward;
    }


    /**
     * جلب أول جائزة مؤهلة للمستخدم بناءً على نقاطه
     */
  public function getEligibleReward(int $userPoints, User $user): ?Reward
{
    // جلب جميع الجوائز التي لديها نقاط مطلوبة أقل من أو يساوي نقاط المستخدم
    $rewards = Reward::where('required_points', '<=', $userPoints)
        ->whereNull('deleted_at')
        ->orderBy('required_points', 'desc')
        ->get();

    // جلب معرفات الجوائز التي حصل عليها المستخدم من قبل
    $grantedRewardIds = UserReward::where('user_id', $user->id)
        ->whereIn('status', ['pending', 'claimed'])
        ->pluck('reward_id')
        ->toArray();

    // تصفية الجوائز لاستبعاد التي حصل عليها من قبل
    $eligibleReward = $rewards->first(function ($reward) use ($grantedRewardIds) {
        return !in_array($reward->id, $grantedRewardIds);
    });

    return $eligibleReward;
}

    /**
     * منح جائزة للمستخدم وإنشاء سجل في user_rewards
     */
    public function grantRewardToUser(User $user, Reward $reward): UserReward
    {
        return UserReward::create([
            'user_id' => $user->id,
            'reward_id' => $reward->id,
            'status' => 'pending',
        ]);
    }
}
