<?php

namespace App\Notifications;

use App\Models\UserReward;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminRewardGrantedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected UserReward $userReward)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $user = $this->userReward->user;
        $reward = $this->userReward->reward;
        $grantedAt = $this->userReward->created_at->format('d/m/Y \ع\ل\ى H:i');
        $adminUrl = route('dashboard.user-rewards.index');

        return (new MailMessage)
            ->subject('إشعار: مستخدم حصل على جائزة جديدة')
            ->greeting('مرحبًا،')
            ->line('تم منح جائزة جديدة لمستخدم في النظام.')
            ->line("**المستخدم:** {$user->name} ({$user->email})")
            ->line("**الجائزة:** {$reward->description}")
            ->line("**النقاط المطلوبة:** {$reward->required_points}")
            ->line("**تاريخ المنح:** {$grantedAt}")
            ->line('')
            ->line('**ملاحظة:** يرجى التواصل مع المستخدم خلال 24 ساعة لترتيب التسليم.')
            ->action('إدارة الجوائز', $adminUrl)
            ->salutation('نظام الجوائز التلقائي');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $user = $this->userReward->user;
        $reward = $this->userReward->reward;
        $grantedAt = $this->userReward->created_at->format('Y-m-d H:i');

        return [
            'title' => 'مستخدم حصل على جائزة',
            'message' => "<strong>{$user->name}</strong> حصل على جائزة: <strong>{$reward->description}</strong>",
            'icon' => 'fa-gift',
            'color' => 'success',
            'url' => route('dashboard.user-rewards.index'),
            'type' => 'admin_reward_granted',
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'reward_id' => $reward->id,
            'reward_description' => $reward->description,
            'required_points' => $reward->required_points,
            'granted_at' => $grantedAt,
        ];
    }
}
