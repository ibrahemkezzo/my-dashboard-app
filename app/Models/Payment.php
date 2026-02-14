<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'salon_id',
        'subscription_id',
        'payment_reference',     // المرجع الداخلي
        'gateway_transaction_id', // رقم الفاتورة في ميسر
        'amount',
        'method',
        'currency',
        'gateway',              // 'moyasar'
        'status',               // 'pending', 'completed', 'failed'
        'gateway_response',     // JSON response
        'failure_reason',
        'processed_at'
    ];

    protected $casts = [
        'gateway_response' => 'array', // ليتم تحويل الـ JSON تلقائياً لمصفوفة
        'processed_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    // هذا التابع يولد كود مرجعي تلقائي عند إنشاء أي دفع جديد
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            if (empty($payment->payment_reference)) {
                $payment->payment_reference = 'PAY-' . strtoupper(Str::random(12));
            }
            if (empty($payment->currency)) {
                $payment->currency = 'SAR';
            }
        });
    }

    // العلاقات
    public function salon()
    {
        return $this->belongsTo(Salon::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    // --- دوال مساعدة للحالة ---

    public function markAsCompleted($gatewayId, $fullResponse)
    {
        // البحث عن العملية الناجحة داخل مصفوفة المدفوعات
        $successfulPayment = collect($fullResponse['payments'] ?? [])
            ->where('status', 'paid')
            ->first();

        // استخراج اسم الشركة (visa, mastercard, mada) من الـ source
        $paymentMethod = $successfulPayment['source']['company'] ?? 'unknown';

        $this->update([
            'status' => 'completed',
            'gateway_transaction_id' => $gatewayId,
            'gateway_response' => $fullResponse, // نصيحة: لا تحذف اللوغ من قاعدة البيانات، ستحتاجه جداً
            'method' => $paymentMethod,
            'processed_at' => now(),
        ]);
    }

    public function markAsFailed($reason, $fullResponse = null)
    {
        $this->update([
            'status' => 'failed',
            'failure_reason' => $reason,
            'gateway_response' => $fullResponse,
        ]);
    }
}
