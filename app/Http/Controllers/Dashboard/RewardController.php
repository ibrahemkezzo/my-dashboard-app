<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRewardRequest;
use App\Http\Requests\UpdatePointsPerBookingRequest;
use App\Http\Requests\UpdateRewardRequest;
use App\Models\Reward;
use App\Services\RewardService;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    protected $rewardService;

    /**
     * Constructor to inject the RewardService.
     *
     * @param RewardService $rewardService
     */
    public function __construct(RewardService $rewardService)
    {
        $this->rewardService = $rewardService;
    }

    /**
     * Display a listing of the rewards with pagination and filtering.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $filters = [
            'description' => $request->input('description'),
            'required_points' => $request->input('required_points'),
        ];

        $rewards = $this->rewardService->getAllRewards($filters);
        $pointsPerBooking = $this->rewardService->getPointsPerBooking();
        return view('dashboard.rewards.index', compact('rewards', 'pointsPerBooking'));
    }

    /**
     * Store a newly created reward in storage.
     *
     * @param CreateRewardRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateRewardRequest $request)
    {
        $this->rewardService->createReward($request->validated());
        return redirect()->route('dashboard.rewards.index')->with('message', [
            'type' => 'success',
            'content' => __('dashboard.created_successfully'),
        ]);
    }

    /**
     * Show the form for editing the specified reward.
     *
     * @param Reward $reward
     * @return \Illuminate\View\View
     */
    public function edit(Reward $reward)
    {
        return view('dashboard.rewards.edit', compact('reward'));
    }

    /**
     * Update the specified reward in storage.
     *
     * @param UpdateRewardRequest $request
     * @param Reward $reward
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRewardRequest $request, Reward $reward)
    {
        $this->rewardService->updateReward($reward, $request->validated());
        return redirect()->route('dashboard.rewards.index')->with('message', [
            'type' => 'success',
            'content' => __('dashboard.updated_successfully'),
        ]);
    }

    /**
     * Remove the specified reward from storage.
     *
     * @param \App\Models\Reward $reward
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reward $reward)
    {
        $this->rewardService->deleteReward($reward);
        return redirect()->route('dashboard.rewards.index')->with('message', [
            'type' => 'success',
            'content' => __('dashboard.deleted_successfully'),
        ]);
    }

    /**
     * Update the points per booking in storage.
     *
     * @param UpdatePointsPerBookingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePoints(UpdatePointsPerBookingRequest $request)
    {
        $this->rewardService->updatePointsPerBooking($request->validated());
        return redirect()->route('dashboard.rewards.index')->with('message', [
            'type' => 'success',
            'content' => __('dashboard.updated_successfully'),
        ]);
    }
}
