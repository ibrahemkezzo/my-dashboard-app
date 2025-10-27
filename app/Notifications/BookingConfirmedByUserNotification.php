<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmedByUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
        protected $booking;

    public function __construct(Booking $booking)
    {
        $this->queue = 'emails';
        $this->booking = $booking;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
                        // إنشاء قائمة الخدمات مع الكميات
        $servicesList = $this->booking->services->map(function ($service) {
            $name = $service->salonSubService->subService->name ?? 'خدمة غير محددة';
            $quantity = $service->quantity > 1 ? ' (x' . $service->quantity . ')' : '';
            return $name . $quantity;
            })->implode(' + ');

        return (new MailMessage)
            ->subject('تأكيد حجز من المستخدم')
            ->greeting('مرحبًا، ' . $notifiable->name)
            ->line('تم تأكيد الحجز من قبل المستخدم.')
            ->line('**تفاصيل الحجز:**')
            ->line('اسم العميل: ' . $this->booking->user->name)
            ->line('الخدمات: ' . ($servicesList ?: 'غير محددة'))
            ->line('الوقت المؤكد: ' . $this->booking->preferred_datetime )
            ->action('عرض الحجز', url('/profile/salon/manager?tab=bookings'))
            ->line('يرجى اتخاذ الإجراءات اللازمة لتجهيز الخدمة.');
    }

/**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        // تنسيق الخدمات للعرض في الـ Dropdown
        $servicesList = $this->booking->services->map(function ($service) {
            $name = $service->salonSubService->subService->name ?? 'خدمة';
            $quantity = $service->quantity > 1 ? " (x{$service->quantity})" : '';
            return $name . $quantity;
        })->implode(' + ');

        $time = $this->booking->preferred_datetime->format('H:i');
        $date = $this->booking->preferred_datetime->format('d/m/Y');

        return [
            // === العناصر المطلوبة للـ Dropdown ===
            'title'   => 'تأكيد حجز جديد',
            'message' => "العميل <strong>{$this->booking->user->name}</strong> أكد حجزه: <br><strong>{$servicesList}</strong> في {$time}",
            'icon'    => 'fa-calendar-check',
            'color'   => 'primary',

            // === الرابط عند النقر ===
            'url'     => url('/profile/salon/manager?tab=bookings'),

            // === بيانات إضافية (اختيارية) ===
            'type'              => 'booking_confirmed',
            'booking_id'        => $this->booking->id,
            'customer_name'     => $this->booking->user->name,
            'services'          => $servicesList,
            'date'              => $date,
            'time'              => $time,
            'preferred_datetime'=> $this->booking->preferred_datetime->toDateTimeString(),
        ];
    }
}
