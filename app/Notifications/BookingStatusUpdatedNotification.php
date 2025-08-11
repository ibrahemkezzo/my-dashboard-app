<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingStatusUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $booking;
    protected $action;

    public function __construct(Booking $booking, string $action)
    {
        $this->booking = $booking;
        $this->action = $action;
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

        $statusMessages = [
            'confirm' => 'تم تأكيد حجزك بنجاح.',
            'modify' => 'تم اقتراح تعديل على حجزك.',
            'rejected' => 'تم رفض حجزك.',
            'cancel' => 'تم إلغاء حجزك.',
            'completed' => 'تم إكمال حجزك.',
        ];

        $message = (new MailMessage)
            ->subject('تحديث حالة الحجز')
            ->greeting('مرحبًا، ' . $notifiable->name)
            ->line($statusMessages[$this->action] ?? 'تم تحديث حالة حجزك.')
            ->line('**تفاصيل الحجز:**')
            ->line('معرف الحجز: ' . $this->booking->booking_number)
            ->line('الصالون: ' . $this->booking->salon->name)
            ->line('الخدمة: ' . $this->booking->salonSubService->subService->name)
            ->line('الوقت المفضل: ' . $this->booking->preferred_datetime);

        if ($this->action === 'modify') {
            $message->line('الوقت المقترح: ' . $this->booking->salon_proposed_datetime)
                    ->line('السعر المقترح: ' . $this->booking->salon_proposed_price)
                    ->line('المدة المقترحة: ' . $this->booking->salon_proposed_duration)
                    ->line('سبب التعديل: ' . $this->booking->salon_modification_reason);
        } elseif ($this->action === 'rejected') {
            $message->line('سبب الرفض: ' . $this->booking->rejection_reason);
        } elseif ($this->action === 'cancel') {
            $message->line('سبب الإلغاء: ' . $this->booking->rejection_reason);
        }

        return $message->action('عرض الحجوزات', url('/profile/bookings'))
                      ->line('شكرًا لاستخدامك منصتنا!');

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
