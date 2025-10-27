<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Config;

class CustomVerifyEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        $this->queue = 'emails'; // تعيين طابور الإيميلات
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('تأكيد بريدك الإلكتروني')
            ->line('مرحبًا! انقر على الزر أدناه لتأكيد بريدك الإلكتروني.')
            ->action('تأكيد البريد', $verificationUrl)
            ->line('إذا لم تقم بطلب هذا، تجاهل الرسالة.');
    }

    /**
     * Get the verification URL for the given notifiable.
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
/**
     * Get the array representation of the notification (for database).
     */
    public function toArray(object $notifiable): array
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return [
            // === العناصر المطلوبة للـ Dropdown ===
            'title'   => 'تأكيد بريدك الإلكتروني',
            'message' => 'انقر هنا لتأكيد حسابك. الرابط صالح لمدة <strong>60 دقيقة</strong>.',
            'icon'    => 'fa-envelope',
            'color'   => 'info',

            // === الرابط عند النقر ===
            'url'     => $verificationUrl,

            // === بيانات إضافية ===
            'type'          => 'email_verification',
            'user_id'       => $notifiable->id,
            'email'         => $notifiable->email,
            'expires_at'    => Carbon::now()->addMinutes(60)->format('Y-m-d H:i:s'),
        ];
    }
}
