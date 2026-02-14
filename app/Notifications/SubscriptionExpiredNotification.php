<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionExpiredNotification extends Notification
{
    use Queueable;

    public $subscription;

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
        return ['mail', 'database']; // أضفنا داتابيز ليظهر له تنبيه داخل لوحة التحكم أيضاً
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $salonName = $this->subscription->salon->name;
        $planName = $this->subscription->plan->name ?? 'خطتكم السابقة';

        return (new MailMessage)
            ->subject('انتهى اشتراك صالون ' . $salonName . ' - ننتظر عودتكم!')
            ->greeting('مرحباً ' . $notifiable->name . '،')
            ->line('لقد انتهت فترة اشتراك صالونكم ('. $salonName .') في باقة ('. $planName .').')
            ->line('نحن في Glowzelle نعتز بشراكتنا معكم، ولا نريد لعملكم أن يتوقف أو تتأثر حجوزات عملائكم.')
            ->line('بتجديد اشتراككم الآن، ستتمكنون من استعادة كافة الصلاحيات وإدارة مواعيدكم بكل سهولة كما اعتدتم.')
            ->action('تجديد الاشتراك الآن', route('front.subscriptions.create'))
            ->line('إذا واجهتم أي صعوبة في عملية التجديد، فريق الدعم الفني جاهز لمساعدتكم في أي وقت.')
            ->line('شكراً لثقتكم بنا وبمنصتنا!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'انتهى اشتراك صالونكم',
            'message' => 'لقد انتهى اشتراكك في باقة ' . ($this->subscription->plan->name ?? ''),
            'subscription_id' => $this->subscription->id,
            'action_url' => route('front.subscriptions.create'),
        ];
    }
}
