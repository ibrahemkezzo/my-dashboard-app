<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRewardStatusRequest;
use App\Services\UserRewardService;
use Illuminate\Http\Request;

class UserRewardController extends Controller
{
    protected $userRewardService;

    /**
     * Constructor to inject the UserRewardService.
     *
     * @param UserRewardService $userRewardService
     */
    public function __construct(UserRewardService $userRewardService)
    {
        $this->userRewardService = $userRewardService;
    }

    /**
     * Display a listing of the user rewards with pagination and filtering.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $filters = [
            'user_name' => $request->input('user_name'),
            'status' => $request->input('status'),
        ];

        $userRewards = $this->userRewardService->getAllUserRewards($filters);
        return view('dashboard.user-rewards.index', compact('userRewards'));
    }

    /**
     * Update the status of the specified user reward.
     *
     * @param UpdateUserRewardStatusRequest $request
     * @param \App\Models\UserReward $userReward
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(UpdateUserRewardStatusRequest $request, \App\Models\UserReward $userReward)
    {
        $this->userRewardService->updateStatus($userReward, $request->validated());
        return redirect()->route('dashboard.user-rewards.index')->with('message', [
            'type' => 'success',
            'content' => __('dashboard.updated_successfully'),
        ]);
    }
}
