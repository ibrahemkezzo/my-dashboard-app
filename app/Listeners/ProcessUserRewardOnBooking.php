<?php

namespace App\Listeners;

use App\Events\BookingCompleted;
use App\Models\User;
use App\Notifications\AdminRewardGrantedNotification;
use App\Notifications\RewardGrantedNotification;
use App\Services\UserRewardService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class ProcessUserRewardOnBooking
{
    /**
     * Create the event listener.
     */
    public function __construct(protected UserRewardService $userRewardService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookingCompleted $event): void
    {
        $booking = $event->booking;
        $user = $booking->user;

        // 1. إضافة النقاط للمستخدم
        $pointsPerBooking = $this->userRewardService->getPointsPerBooking();
        // dump($pointsPerBooking);
        if($user->hasRole('user')){
            $user->increment('points', $pointsPerBooking);
        }

        // 2. التحقق من استحقاق جائزة
        $eligibleReward = $this->userRewardService->getEligibleReward($user->points, $user);

        if ($eligibleReward) {
            // 3. منح الجائزة للمستخدم
            $userReward = $this->userRewardService->grantRewardToUser($user, $eligibleReward);

            // 4. إرسال إيميل للمستخدم
            Notification::send($user,new RewardGrantedNotification($userReward));

            // 5. إرسال إيميل للإدمن
            // \Illuminate\Support\Facades\Mail::to(config('mail.admin_email'))
            //     ->send(new \App\Mail\AdminRewardGrantedMail($userReward));
            $admins = User::role(['super-admin'])->get();
            Notification::send($admins, new AdminRewardGrantedNotification($userReward));
        }
    }
}
