<?php

namespace App\Http\Controllers\Frontend;

use App\Contracts\PaymentGatewayInterface;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class SubscriptionUserController extends Controller
{
    protected $service;
    protected $paymentGateway;

    public function __construct(SubscriptionService $service, PaymentGatewayInterface $paymentGateway)
    {
        $this->service = $service;
        $this->paymentGateway = $paymentGateway;
    }

    public function create()
    {
        $plans = SubscriptionPlan::where('is_active', true)
            ->where('price', '>', 0)
            ->get();

        return view('frontend.subscriptions.create', compact('plans'));
    }

    public function payment(Request $request, SubscriptionPlan $plan)
    {
        $salon = Auth::user()->salon;

        try {
            // نضع البارامترات الضرورية في رابط العودة لنستلمها لاحقاً
            // ميسر ستقوم بإضافة ?id=INVOICE_ID&status=PAID لهذا الرابط عند العودة
            $callbackUrl = route('front.subscriptions.callback');

            $invoiceResult = $this->service->initiatePayment($salon, $plan, $callbackUrl);

            if (empty($invoiceResult['url'])) {
                throw new Exception('Moyasar did not return a payment URL');
            }

            // توجيه المستخدم لصفحة ميسر الآمنة
            return redirect()->away($invoiceResult['url']);
        } catch (Exception $e) {
            Log::error('Payment Init Error', ['msg' => $e->getMessage()]);
            return redirect()->back()->with('message', [
                'type'    => 'error',
                'content' => 'حدث خطأ في الاتصال ببوابة الدفع. يرجى المحاولة مرة أخرى.'
            ]);
        }
    }

    // دالة العودة والتحقق (قلب الأمان)
public function callback(Request $request)
{
    // ميسر ترسل البيانات في الـ URL Query String
    $invoiceId = $request->query('id');
    $status = $request->query('status');

    // البيانات التي أضفتها أنت يدوياً في رابط الـ callback
    $salonId = $request->query('salon_id');
    $planId = $request->query('plan_id');

    // تسجيل البيانات للتأكد من وصولها (للـ Debug فقط)
    Log::info('Moyasar Callback Received', [
        'invoice_id' => $invoiceId,
        'status' => $status,
        'salon_id' => $salonId,
        'request' => $request->all()
    ]);

    if (!$invoiceId || $status !== 'paid') {
        Log::warning('Moyasar payment failed or cancelled', [
            'id' => $invoiceId,
            'status' => $status
        ]);
        return redirect()->route('front.profile.salon.manager')->with('message', [
                'type'    => 'error',
                'content' => 'عملية الدفع لم تكتمل. يرجى المحاولة مرة أخرى.'
            ]);
    }

    try {
        // التحقق من الفاتورة عبر API ميسر (أهم خطوة أمان)
        $invoiceData = $this->paymentGateway->fetchInvoice($invoiceId);

        if ($invoiceData['status'] === 'paid') {
            $salon = \App\Models\Salon::findOrFail($salonId);
            $plan = \App\Models\SubscriptionPlan::findOrFail($planId);

            // جلب أول عملية دفع ناجحة من مصفوفة المدفوعات داخل الفاتورة
            $paymentId = $invoiceData['payments'][0]['id'] ?? $invoiceId;

            // تفعيل الاشتراك
            $this->service->confirmPaymentAndUpdateSubscription($paymentId, $salon, $plan);

            return redirect()->route('front.profile.salon.manager')->with('message', [
                'type'    => 'success',
                'content' => 'تم تفعيل الاشتراك بنجاح!'
            ]);
        }

        return redirect()->route('front.profile.salon.manager')->with('message', [
                'type'    => 'error',
                'content' => 'حدث خطأ أثناء معالجة الاشتراك. تواصل مع الدعم.'
            ]);

    } catch (Exception $e) {
        Log::error('Callback Error', ['msg' => $e->getMessage()]);
        return redirect()->route('front.profile.salon.manager')->with('message', [
                'type'    => 'error',
                'content' => 'حدث خطأ أثناء معالجة الاشتراك. تواصل مع الدعم.'
            ]);
    }
}

    public function webhook(Request $request)
    {
        $payload = $this->paymentGateway->verifyWebhook($request);

        if (!$payload) {
            return response('Invalid signature', 403);
        }

        // معالجة async (مثل paid بعد 3DS)
        if ($payload['status'] === 'paid') {
            // جلب salon و plan من metadata أو DB
            // هنا افترض metadata في createPayment
            // $this->service->confirmPaymentAndUpdateSubscription($payload['id'], $salon, $plan);
        }

        return response('OK', 200);
    }

    // renew و processRenew مشابه، مع redirect إلى payment route
    public function renew(Subscription $subscription)
    {
        if ($subscription->salon->owner_id !== Auth::id()) {
            abort(403);
        }

        $plans = SubscriptionPlan::where('is_active', true)
            ->where('price', '>', 0)
            ->get();

        return view('frontend.subscriptions.renew', compact('subscription', 'plans'));
    }
}
