<?php

namespace App\Notifications;

use App\Models\UserReward;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RewardGrantedNotification extends Notification implements ShouldQueue
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
        $reward = $this->userReward->reward;
        $pointsRequired = $reward->required_points;
        $grantedAt = $this->userReward->created_at->format('d/m/Y H:i');

        return (new MailMessage)
            ->subject('مبروك! لقد حصلت على جائزة جديدة')
            ->greeting('مرحبًا ' . $notifiable->name . '،')
            ->line('**تهانينا الحارة!** لقد جمعت نقاطًا كافية وحصلت على جائزة مميزة من منصتنا.')
            ->line('**تفاصيل الجائزة:**')
            ->line('- **الجائزة:** ' . $reward->description)
            ->line('- **النقاط المطلوبة:** ' . $pointsRequired . ' نقطة')
            ->line('- **تاريخ المنح:** ' . $grantedAt)
            ->line('')
            ->line('سوف يقوم **فريق دعم العملاء** بالتواصل معك خلال **24 ساعة** لترتيب استلام الجائزة.')
            ->line('يرجى التأكد من تفعيل رقم هاتفك وبريدك الإلكتروني.')
            ->action('عرض لوحة التحكم', route('front.home'))
            ->line('شكرًا لثقتك ومشاركتك المستمرة!')
            ->salutation('تحياتنا،' . "\n" . 'فريق ' . config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
       $reward = $this->userReward->reward;
        $grantedAt = $this->userReward->created_at->format('Y-m-d H:i');

        return [
            // === العناصر المطلوبة للـ Dropdown ===
            'title'   => 'مبروك! حصلت على جائزة',
            'message' => "لقد فزت بـ <strong>{$reward->description}</strong> بعد جمع {$reward->required_points} نقطة!",
            'icon'    => 'fa-gift',
            'color'   => 'success',

            // === الرابط عند النقر ===
            'url'     => route('front.home'), // تأكد من وجود هذا الـ route

            // === بيانات إضافية (اختيارية) ===
            'type'               => 'reward_granted',
            'reward_id'          => $this->userReward->reward_id,
            'reward_description' => $reward->description,
            'required_points'    => $reward->required_points,
            'granted_at'         => $grantedAt,
        ];
    }
}
