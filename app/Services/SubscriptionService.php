<?php

namespace App\Services;

use App\Contracts\PaymentGatewayInterface;
use App\Contracts\SubscriptionRepositoryInterface;
use App\Models\Payment;
use App\Models\Salon;
use App\Models\Subscription;
use App\Models\SubscriptionHistory;
use App\Models\SubscriptionPlan;
use App\Notifications\RenewalReminderNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionService
{
    protected $repository;
    protected $paymentGateway;

    public function __construct(
        SubscriptionRepositoryInterface $repository,
        PaymentGatewayInterface $paymentGateway
    ) {
        $this->repository = $repository;
        $this->paymentGateway = $paymentGateway;
    }

// ==========================================
    // 1. منطق الدفع الإلكتروني (تم تحديثه)
    // ==========================================

    /**
     * إنشاء سجل دفع محلي وطلب فاتورة من بوابة الدفع
     */
    public function initiatePayment(Salon $salon, SubscriptionPlan $plan, string $callbackUrl): array
    {
        Log::info('--- Start Initiate Payment Process ---', [
            'salon_id' => $salon->id,
            'plan_id' => $plan->id
        ]);

        if ($plan->price <= 0) {
            Log::warning('Attempted to initiate payment for a free plan', ['plan_id' => $plan->id]);
            throw new Exception('Cannot initiate payment for free plan');
        }

        $subscription = $this->getOrCreateCurrentSubscription($salon);

        return DB::transaction(function () use ($salon, $plan, $subscription, $callbackUrl) {
            // 1. إنشاء سجل الدفع المحلي
            $localPayment = Payment::create([
                'salon_id'        => $salon->id,
                'subscription_id' => $subscription->id,
                'amount'          => $plan->price,
                'currency'        => 'SAR',
                'gateway'         => 'moyasar',
                'status'          => 'pending',
            ]);

            Log::info('Local payment record created', [
                'payment_id' => $localPayment->id,
                'reference' => $localPayment->payment_reference
            ]);

            // 2. تجهيز الرابط والبيانات
            $separator = str_contains($callbackUrl, '?') ? '&' : '?';
            $finalCallbackUrl = $callbackUrl . $separator . 'payment_ref=' . $localPayment->payment_reference;

            $paymentData = [
                'amount'       => $plan->price * 100,
                'currency'     => 'SAR',
                'description'  => "اشتراك صالون {$salon->name} - خطة {$plan->name}",
                'callback_url' => $finalCallbackUrl,
                'metadata'     => [
                    'local_payment_id' => $localPayment->id,
                    'payment_ref'      => $localPayment->payment_reference,
                    'plan_id'          => $plan->id,
                ],
            ];

            try {
                Log::info('Sending request to Moyasar Gateway', ['payload' => $paymentData]);

                $invoiceResult = $this->paymentGateway->createInvoice($paymentData);

                Log::info('Moyasar Invoice created successfully', ['invoice_id' => $invoiceResult['id']]);

                // 3. تحديث السجل المحلي بالـ Invoice ID
                $localPayment->update([
                    'gateway_transaction_id' => $invoiceResult['id'],
                    'gateway_response'       => $invoiceResult
                ]);

                return $invoiceResult;
            } catch (Exception $e) {
                Log::error('Failed to create Moyasar Invoice', [
                    'payment_id' => $localPayment->id,
                    'error' => $e->getMessage()
                ]);
                throw $e;
            }
        });
    }

    /**
     * معالجة العودة من بوابة الدفع وتفعيل الاشتراك
     */
    public function handlePaymentCallback(string $paymentRef): array
    {
        Log::info('--- Callback Handling Started ---', ['payment_ref' => $paymentRef]);

        try {
            $payment = Payment::where('payment_reference', $paymentRef)->first();

            if (!$payment) {
                Log::error('Payment reference not found in database', ['payment_ref' => $paymentRef]);
                throw new Exception("Local payment record not found for ref: {$paymentRef}");
            }

            return DB::transaction(function () use ($payment) {
                $payment->lockForUpdate();

                if ($payment->status === 'completed') {
                    Log::info('Payment already processed and completed', ['payment_id' => $payment->id]);
                    return ['success' => true, 'message' => 'تم تفعيل الاشتراك بنجاح!'];
                }

                Log::info('Fetching invoice status from Moyasar', ['invoice_id' => $payment->gateway_transaction_id]);

                $invoiceData = $this->paymentGateway->fetchInvoice($payment->gateway_transaction_id);

                Log::info('Moyasar Invoice Status Received', [
                    'invoice_id' => $invoiceData['id'],
                    'status' => $invoiceData['status'],
                    'invoice' => $invoiceData
                ]);

                if ($invoiceData['status'] === 'paid') {
                    $payment->markAsCompleted($invoiceData['id'], $invoiceData);

                    $planId = $invoiceData['metadata']['plan_id'] ?? $payment->subscription->subscription_plan_id;
                    $plan = SubscriptionPlan::findOrFail($planId);

                    $this->activatePaidSubscription($payment->salon, $plan, $payment);

                    Log::info('Subscription successfully activated via Callback/Webhook', [
                        'salon_id' => $payment->salon_id,
                        'payment_id' => $payment->id
                    ]);

                    return ['success' => true, 'message' => 'تم تفعيل الاشتراك بنجاح!'];
                }

                Log::warning('Payment failed or not paid yet', [
                    'invoice_id' => $invoiceData['id'],
                    'status' => $invoiceData['status']
                ]);

                $payment->markAsFailed($invoiceData['message'] ?? 'Payment Failed', $invoiceData);
                return ['success' => false, 'message' => 'عملية الدفع لم تكتمل.'];
            });
        } catch (Exception $e) {
            Log::error('Critical error in handlePaymentCallback', [
                'payment_ref' => $paymentRef,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return ['success' => false, 'message' => 'حدث خطأ أثناء معالجة الطلب.'];
        }
    }

    /**
     * تفعيل الاشتراك الفعلي وتحديث بيانات الصالون
     */
    protected function activatePaidSubscription(Salon $salon, SubscriptionPlan $plan, Payment $payment): void
    {
        $subscription = $this->getOrCreateCurrentSubscription($salon);

        $newEndDate = ($subscription->end_date && $subscription->end_date->isFuture())
            ? $subscription->end_date->addDays($plan->duration_days)
            : Carbon::now()->addDays($plan->duration_days);

        $subscription->update([
            'subscription_plan_id' => $plan->id,
            'status'               => 'active',
            'end_date'             => $newEndDate,
        ]);

        $salon->update(['is_active' => true]);

        $this->logHistory($subscription, $plan, $payment->amount, 'online', "تجديد عبر ميسر (مرجع: {$payment->payment_reference})");

        Log::info('ActivatePaidSubscription: Subscription and Salon updated', [
            'salon_id' => $salon->id,
            'new_end_date' => $newEndDate->toDateTimeString()
        ]);
    }


    // دفع يدوي - اسناد أو تجديد
    public function assignOrRenewManual(Salon $salon, SubscriptionPlan $plan, ?float $paidAmount = null, ?string $note = ''): Subscription
    {
        $subscription = $this->getOrCreateCurrentSubscription($salon);

        $isFreeTrial = $plan->price <= 0;

        $subscription->subscription_plan_id = $plan->id;
        $subscription->end_date = $subscription->end_date
            ? $subscription->end_date->addDays($plan->duration_days)
            : Carbon::now()->addDays($plan->duration_days);
        $subscription->status = $isFreeTrial ? 'trial' : 'active';
        $subscription->save();



        // لو مجاني، ما ننشئ دفع
        if (!$isFreeTrial) {
            $subscription->payments()->create([
                'payment_id' => 'manual_' . uniqid(),
                'salon_id' => $salon->id,
                'amount' => $paidAmount ?? $plan->price,
                'status' => 'completed',
                'method' => 'cash',
                'note' => $note,
            ]);
        }
        $salon->is_active = true;
        $salon->save();

        $historyNote = $isFreeTrial ? 'Free trial assigned/renewed' : ($note ?: 'Manual renewal/assignment');
        $historyAmount = $isFreeTrial ? 0 : ($paidAmount ?? $plan->price);
        $historyMethod = $isFreeTrial ? 'free_trial' : 'cash';

        $this->logHistory($subscription, $plan, $historyAmount, $historyMethod, $historyNote);

        return $subscription;
    }

    protected function getOrCreateCurrentSubscription(Salon $salon): Subscription
    {
        $subscription = $salon->subscription;

        if (!$subscription) {
            $subscription = Subscription::create([
                'salon_id' => $salon->id,
                'subscription_plan_id' => null,
                'start_date' => Carbon::now(),
                'end_date' => null,
                'status' => 'trial',
            ]);
        }

        return $subscription;
    }

    protected function logHistory(Subscription $subscription, SubscriptionPlan $plan, float $amount, string $method, ?string $note = ''): void
    {
        SubscriptionHistory::create([
            'subscription_id' => $subscription->id,
            'subscription_plan_id' => $plan->id,
            'start_date' => $subscription->start_date,
            'end_date' => $subscription->end_date,
            'paid_amount' => $amount,
            'payment_method' => $method,
            'note' => $note,
        ]);
    }

    public function suspend(Subscription $subscription): void
    {
        $subscription->status = 'suspended';
        $subscription->save();
        $subscription->salon->is_active = false;
        $subscription->salon->save();

        $this->logHistory($subscription, $subscription->plan, 0, 'manual', 'Subscription suspended');
    }

    public function expired(Subscription $subscription): void
    {
        $subscription->status = 'expired';
        $subscription->save();
        $subscription->salon->is_active = false;
        $subscription->salon->save();

        $this->logHistory($subscription, $subscription->plan, 0, 'manual', 'Subscription suspended');
    }

    public function activate(Subscription $subscription): void
    {
        $subscription->status = 'active';
        $subscription->save();
        $subscription->salon->is_active = true;
        $subscription->salon->save();

        // تسجيل في التاريخ إذا كان عندك histories
        $this->logHistory($subscription, $subscription->plan, 0, 'manual', 'Reactivate');
    }

    public function updateEndDate(Subscription $subscription, Carbon $newEndDate): void
    {
        $oldEndDate = $subscription->end_date;
        $isPast = $newEndDate->isPast();

        // 1. تحديث التاريخ
        $subscription->end_date = $newEndDate;

        // 2. تحديد الحالة بناءً على التاريخ ونوع الخطة
        if ($isPast) {
            $subscription->status = 'expired';
        } else {
            // إذا كان سعر الخطة 0 أو غير محددة (خطة تجريبية)، نضع الحالة trial، وإلا active
            $isFree = optional($subscription->plan)->price <= 0;
            $subscription->status = $isFree ? 'trial' : 'active';
        }

        $subscription->save();

        // 3. تحديث حالة الصالون (تنشيط أو تعطيل)
        $subscription->salon->update([
            'is_active' => !$isPast
        ]);

        // 4. تسجيل العملية في السجل
        $this->logHistory(
            $subscription,
            $subscription->plan,
            0,
            'manual',
            "تعديل تاريخ الانتهاء من " . ($oldEndDate?->format('Y-m-d') ?: 'N/A') . " إلى {$newEndDate->format('Y-m-d')} (الحالة: {$subscription->status})"
        );
    }

    public function getSubscriptions(Request $request): LengthAwarePaginator
    {
        return Salon::with('subscription.plan')
            ->when($request->search, fn($q, $search) => $q->where('name', 'like', "%{$search}%"))
            ->when($request->status, fn($q, $status) => $q->whereHas('subscription', fn($sq) => $sq->where('status', $status)))
            ->paginate(15)->withQueryString();
    }

    public function getStatistics(Request $request): array
    {
        $period = $request->period ?? 'monthly';
        $start = match ($period) {
            'daily' => Carbon::today(),
            'weekly' => Carbon::now()->startOfWeek(),
            'monthly' => Carbon::now()->startOfMonth(),
            'yearly' => Carbon::now()->startOfYear(),
            default => Carbon::parse('1970-01-01'),
        };
        $end = Carbon::now();

        $revenue = Payment::where('status', 'completed')
            ->whereBetween('created_at', [$start, $end])
            ->sum('amount');

        $paid = Payment::where('status', 'completed')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $trial = Salon::whereHas('subscription', function ($q) {
            $q->where('status', 'trial')
                ->orWhereHas('plan', fn($pq) => $pq->where('price', '<=', 0));
        })->count();

        $subscribed = Salon::whereHas('subscription', function ($q) {
            $q->where('status', 'active')
                ->orWhere('status', 'trial');
        })->count();

        return compact('revenue', 'paid', 'trial', 'subscribed');
    }

    public function sendRenewalReminders(): Collection
    {
        return $this->repository->findNeedingReminders(); // قبل 5 أيام
    }

    public function findExpired(): Collection
    {
        return $this->repository->findExpired();
    }

    public function getVisibleHistory(Salon $salon, int $limit = 10)
    {
        return $salon->subscription->histories()
            ->whereIn('payment_method', ['online', 'cash', 'free_trial'])
            ->latest()
            ->take($limit)
            ->get();
    }
}
