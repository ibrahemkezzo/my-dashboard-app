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

    // إنشاء دفع جديد (يعيد رابط الدفع المستضاف)
    public function initiatePayment(Salon $salon, SubscriptionPlan $plan, string $callbackUrl): array
    {
        if ($plan->price <= 0) {
            throw new Exception('Cannot initiate payment for free plan');
        }

        $paymentData = [
            'amount' => $plan->price * 100, // تحويل للهللة
            'currency' => 'SAR',
            'description' => 'اشتراك صالون ' . $salon->name . ' - خطة ' . $plan->name,
            'callback_url' => $callbackUrl, // سيتم تمرير البارامترات لاحقاً في الكونترولر إذا لزم
            'metadata' => [
                'salon_id' => $salon->id,
                'plan_id' => $plan->id,
            ],
        ];

        // نستخدم دالة الفاتورة الجديدة
        return $this->paymentGateway->createInvoice($paymentData);
    }

    // تأكيد الدفع وتحديث الاشتراك (يُستدعى من callback أو webhook)
    public function confirmPaymentAndUpdateSubscription(string $paymentId, Salon $salon, SubscriptionPlan $plan): Subscription
    {
        return DB::transaction(function () use ($paymentId, $salon, $plan) {
            $paymentResult = $this->paymentGateway->fetchPayment($paymentId);

            if ($paymentResult['status'] !== 'paid') {
                Log::warning('Payment not paid', ['payment_id' => $paymentId, 'status' => $paymentResult['status']]);
                throw new Exception('Payment not completed');
            }

            $subscription = $this->getOrCreateCurrentSubscription($salon);

            $subscription->subscription_plan_id = $plan->id;
            $subscription->end_date = $subscription->end_date
                ? $subscription->end_date->addDays($plan->duration_days)
                : Carbon::now()->addDays($plan->duration_days);
            $subscription->status = 'active';
            $subscription->save();

            // سجل الدفع
            $subscription->payments()->create([
                'payment_id' => $paymentResult['id'],
                'amount' => $plan->price,
                'status' => 'paid',
                'method' => 'online',
                'gateway_response' => $paymentResult,
            ]);

            // حفظ توكن إذا موجود (للتجديد السريع)
            if (isset($paymentResult['source']['token'])) {
                $subscription->payment_token = encrypt($paymentResult['source']['token']);
                $subscription->save();
            }

            // تسجيل في التاريخ
            $this->logHistory($subscription, $plan, $plan->price, 'online', 'Subscribed/Renewed via Moyasar');

            Log::info('Subscription updated after successful payment', [
                'salon_id' => $salon->id,
                'payment_id' => $paymentId,
            ]);

            return $subscription;
        });
    }

    // دفع إلكتروني - اشتراك جديد أو تجديد
    // public function subscribeOrRenewOnline(Salon $salon, SubscriptionPlan $plan, Request $request): Subscription
    // {
    //     if ($plan->price <= 0) {
    //         throw new Exception('Cannot subscribe online to free plan');
    //     }

    //     return DB::transaction(function () use ($salon, $plan, $request) {
    //         $subscription = $this->getOrCreateCurrentSubscription($salon);

    //         // معالجة الدفع أولاً
    //         $paymentResult = $this->processOnlinePayment($subscription, $request, $plan);

    //         Log::info('Moyasar payment successful', [
    //             'salon_id' => $salon->id,
    //             'plan_id' => $plan->id,
    //             'payment_id' => $paymentResult['id'],
    //             'amount' => $paymentResult['amount'] / 100,
    //         ]);

    //         // فقط بعد نجاح الدفع، حدث الاشتراك
    //         $subscription->subscription_plan_id = $plan->id;
    //         $subscription->end_date = $subscription->end_date
    //             ? $subscription->end_date->addDays($plan->duration_days)
    //             : Carbon::now()->addDays($plan->duration_days);
    //         $subscription->status = 'active';
    //         $subscription->save();

    //         // سجل الدفع في DB
    //         $subscription->payments()->create([
    //             'payment_id' => $paymentResult['id'],
    //             'amount' => $plan->price,
    //             'status' => 'paid',
    //             'method' => 'online',
    //             'gateway_response' => $paymentResult, // كامل الـ response للـ debug
    //         ]);

    //         // حفظ التوكن إذا موجود
    //         if (isset($paymentResult['token'])) {
    //             $subscription->payment_token = encrypt($paymentResult['token']);
    //             $subscription->save();
    //         }

    //         // تسجيل في التاريخ
    //         $this->logHistory($subscription, $plan, $plan->price, 'online', 'Subscribed/Renewed online via Moyasar');

    //         return $subscription;
    //     });
    // }

    // protected function processOnlinePayment(Subscription $subscription, Request $request, SubscriptionPlan $plan): array
    // {
    //     $paymentData = [
    //         'amount' => $plan->price * 100,
    //         'currency' => 'SAR',
    //         'description' => 'Subscription for salon ' . $subscription->salon->name,
    //     ];

    //     if (config('services.moyasar.enable_tokenization') && $subscription->payment_token && !$request->has('new_card')) {
    //         $paymentData['source'] = [
    //             'type' => 'token',
    //             'token' => decrypt($subscription->payment_token),
    //         ];
    //     } else {
    //         $paymentData['source'] = $request->input('source');
    //     }

    //     Log::info('Initiating Moyasar payment', [
    //         'salon_id' => $subscription->salon_id,
    //         'plan_id' => $plan->id,
    //         'amount' => $plan->price,
    //         'source_type' => $paymentData['source']['type'] ?? 'new_card',
    //     ]);

    //     $payment = $this->paymentGateway->createInvoice($paymentData);

    //     if ($payment['status'] !== 'paid') {
    //         Log::error('Moyasar payment failed', [
    //             'salon_id' => $subscription->salon_id,
    //             'response' => $payment,
    //         ]);
    //         throw new Exception('Payment failed: ' . ($payment['message'] ?? 'Unknown error'));
    //     }

    //     return $payment;
    // }

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
                'amount' => $paidAmount ?? $plan->price,
                'status' => 'paid',
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

        $subscription->end_date = $newEndDate;
        $subscription->status = $newEndDate->isPast() ? 'expired' : 'active';
        $subscription->save();

        if ($newEndDate->isPast()) {
            $subscription->salon->is_active = false;
            $subscription->salon->save();
        }

        $this->logHistory($subscription, $subscription->plan, 0, 'manual', "End date updated from {$oldEndDate?->format('Y-m-d')} to {$newEndDate->format('Y-m-d')}");
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

        $revenue = Payment::where('status', 'paid')
            ->whereBetween('created_at', [$start, $end])
            ->sum('amount');

        $paid = Payment::where('status', 'paid')
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $trial = Salon::whereHas('subscription', function ($q) {
            $q->where('status', 'trial')
                ->orWhereHas('plan', fn($pq) => $pq->where('price', '<=', 0));
        })->count();

        $subscribed = Salon::whereHas('subscription', function ($q) {
            $q->where('status', 'active')
                ->whereHas('plan', fn($pq) => $pq->where('price', '>', 0));
        })->count();

        return compact('revenue', 'paid', 'trial', 'subscribed');
    }

    public function sendRenewalReminders(): void
    {
        $subscriptions = $this->repository->findNeedingReminders(); // قبل 5 أيام

        foreach ($subscriptions as $subscription) {
            $subscription->salon->notify(new RenewalReminderNotification($subscription));
        }
    }

    public function findExpired(): Collection
    {
        return $this->repository->findExpired();
    }
}
