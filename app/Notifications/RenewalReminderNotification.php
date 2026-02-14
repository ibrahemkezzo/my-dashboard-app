<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RenewalReminderNotification extends Notification
{
    use Queueable;

    protected $subscription;

    /**
     * Create a new notification instance.
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        // نرسل عبر البريد الإلكتروني ونخزن التنبيه في قاعدة البيانات ليظهر في لوحة التحكم
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $salonName = $this->subscription->salon->name;
        $endDate = $this->subscription->end_date->format('Y-m-d');
        $daysRemaining =(int) now()->diffInDays($this->subscription->end_date);

        return (new MailMessage)
            ->subject('تذكير: اشتراك صالون ' . $salonName . ' قارب على الانتهاء')
            ->greeting('أهلاً بكِ شريكتنا المبدعة في Glowzelle،')
            ->line('نتمنى أن تكون رحلتكِ معنا مثمرة ومليئة بالنجاحات.')
            ->line('نود تذكيركِ بأن اشتراك صالونكِ الحالي سينتهي قريباً بتاريخ:')
            ->line('🗓️ **' . $endDate . '** (متبقي ' . $daysRemaining . ' أيام فقط)')
            ->line('لضمان استمرار استقبال حجوزات عميلاتكِ دون انقطاع، وللحفاظ على سير العمل في الصالون بكل سلاسة، ندعوكِ لتجديد اشتراككِ الآن.')
            ->action('تجديد الاشتراك الآن', route('front.subscriptions.create'))
            ->line('بقاء صالونكِ متصلاً معنا يسعدنا دائماً، ونحن هنا لدعم نمو أعمالكِ باستمرار.')
            ->line('شكراً لثقتكِ الدائمة بنا!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'اقترب موعد انتهاء الاشتراك',
            'message' => 'اشتراك صالونكم ينتهي في ' . $this->subscription->end_date->format('Y-m-d'),
            'salon_id' => $this->subscription->salon_id,
            'action_url' => route('front.subscriptions.create'),
        ];
    }
}
