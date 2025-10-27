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
        $this->queue = 'emails';
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
        return ['mail', 'database'];
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
                        // إنشاء قائمة الخدمات مع الكميات
        $servicesList = $this->booking->services->map(function ($service) {
            $name = $service->salonSubService->subService->name ?? 'خدمة غير محددة';
            $quantity = $service->quantity > 1 ? ' (x' . $service->quantity . ')' : '';
            return $name . $quantity;
            })->implode(' + ');

        $message = (new MailMessage)
            ->subject('تحديث حالة الحجز')
            ->greeting('مرحبًا، ' . $notifiable->name)
            ->line($statusMessages[$this->action] ?? 'تم تحديث حالة حجزك.')
            ->line('**تفاصيل الحجز:**')
            ->line('معرف الحجز: ' . $this->booking->booking_number)
            ->line('الصالون: ' . $this->booking->salon->name)
            ->line('الخدمات: ' . ($servicesList ?: 'غير محددة'))
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
     * Get the array representation of the notification (for database).
     */
    public function toArray(object $notifiable): array
    {

        $time = $this->booking->preferred_datetime->format('H:i');
        $date = $this->booking->preferred_datetime->format('d/m/Y');

        // تحديد العنوان والأيقونة واللون حسب الحالة
        $config = [
            'confirm' => [
                'title'   => 'تم تأكيد حجزك',
                'icon'    => 'fa-check-circle',
                'color'   => 'success',
            ],
            'modify' => [
                'title'   => 'اقتراح تعديل على حجزك',
                'icon'    => 'fa-clock',
                'color'   => 'warning',
            ],
            'rejected' => [
                'title'   => 'تم رفض حجزك',
                'icon'    => 'fa-times-circle',
                'color'   => 'danger',
            ],
            'cancel' => [
                'title'   => 'تم إلغاء حجز'.$this->booking->user->name,
                'icon'    => 'fa-ban',
                'color'   => 'secondary',
            ],
            'completed' => [
                'title'   => 'تم إكمال حجزك',
                'icon'    => 'fa-check-double',
                'color'   => 'info',
            ],
        ];

        $status = $config[$this->action] ?? [
            'title' => 'تحديث حالة الحجز',
            'icon'  => 'fa-bell',
            'color' => 'primary',
        ];

        // بناء الرسالة
        $message = "في صالون <strong>{$this->booking->salon->name}</strong>";

        $message .= " يوم {$date} الساعة {$time}";

        // إضافة تفاصيل التعديل
        if ($this->action === 'modify') {
            $newTime = $this->booking->salon_proposed_datetime?->format('H:i') ?? 'غير محدد';
            $message .= "<br> اقتراح: {$newTime} | {$this->booking->salon_proposed_price} ريال";
        }

        return [
            // === العناصر المطلوبة للـ Dropdown ===
            'title'   => $status['title'],
            'message' => $message,
            'icon'    => $status['icon'],
            'color'   => $status['color'],

            // === الرابط عند النقر ===
            'url'     => url('/profile/bookings'),

            // === بيانات إضافية ===
            'type'                   => 'booking_status_updated',
            'action'                 => $this->action,
            'booking_id'             => $this->booking->id,
            'booking_number'         => $this->booking->booking_number,
            'salon_name'             => $this->booking->salon->name,
            'preferred_date'         => $date,
            'preferred_time'         => $time,
            'preferred_datetime'     => $this->booking->preferred_datetime->toDateTimeString(),

            // // تفاصيل التعديل (إذا وجدت)
            // 'proposed_datetime'      => $this->booking->salon_proposed_datetime?->toDateTimeString(),
            // 'proposed_price'         => $this->booking->salon_proposed_price,
            // 'proposed_duration'      => $this->booking->salon_proposed_duration,
            // 'modification_reason'    => $this->booking->salon_modification_reason,
            // 'rejection_reason'       => $this->booking->rejection_reason,
        ];
    }
}
