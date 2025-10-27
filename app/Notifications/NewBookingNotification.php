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
            ->subject('حجز جديد في صالونك')
            ->greeting('مرحبًا، ' . $notifiable->name)
            ->line('تم تقديم حجز جديد في صالونك.')
            ->line('**تفاصيل الحجز:**')
            ->line('اسم العميل: ' . $this->booking->user->name)
            ->line('الخدمات: ' . ($servicesList ?: 'غير محددة'))
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
       $servicesList = $this->booking->services->map(function ($service) {
            $name = $service->salonSubService->subService->name ?? 'خدمة';
            $quantity = $service->quantity > 1 ? " (x{$service->quantity})" : '';
            return $name . $quantity;
        })->implode(' + ');

        $preferredTime = \Carbon\Carbon::parse($this->booking->preferred_datetime)
            ->format('d/m H:i');

        return [
            // === العناصر الأساسية للـ Dropdown ===
            'title'   => 'حجز جديد من ' . $this->booking->user->name,
            'message' => "طلب <strong>{$servicesList}</strong> في {$preferredTime}",
            'icon'    => 'fa-calendar-check',
            'color'   => 'primary',

            // === الرابط عند النقر ===
            'url'     => route('front.profile.salon.manager') . '?tab=bookings',

            // === بيانات إضافية (اختيارية) ===
            'type'          => 'new_booking',
            'booking_id'    => $this->booking->id,
            'user_name'     => $this->booking->user->name,
            'user_email'    => $this->booking->user->email,
            'services'      => $servicesList,
            'preferred_time'=> $preferredTime,
            'created_at'    => now()->toDateTimeString(),
        ];
    }
}
