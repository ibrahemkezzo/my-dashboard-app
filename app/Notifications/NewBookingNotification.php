<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBookingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;

    /**
     * Create a new notification instance.
    */

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('حجز جديد في صالونك')
            ->greeting('مرحبًا، ' . $notifiable->name)
            ->line('تم تقديم حجز جديد في صالونك.')
            ->line('**تفاصيل الحجز:**')
            ->line('اسم العميل: ' . $this->booking->user->name)
            ->line('الخدمة: ' . $this->booking->salonSubService->subService->name)
            ->line('الوقت المفضل: ' . $this->booking->preferred_datetime)
            ->action('عرض الحجز', url('/profile/salon/manager?tab=bookings'))
            ->line('يرجى مراجعة الحجز واتخاذ الإجراء المناسب.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
