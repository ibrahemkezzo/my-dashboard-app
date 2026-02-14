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

    /**
     * بدء عملية الدفع
     */
    public function payment(Request $request, SubscriptionPlan $plan)
    {
        $salon = Auth::user()->salon;

        try {
            // نرسل فقط رابط الكولباك الأساسي، البيانات ستُحفظ في الـ Metadata
            $callbackUrl = route('front.subscriptions.callback');

            // السيرفس تتكفل بإنشاء السجل المحلي والاتصال بميسر
            $invoiceResult = $this->service->initiatePayment($salon, $plan, $callbackUrl);

            return redirect()->away($invoiceResult['url']);
        } catch (Exception $e) {
            return redirect()->back()->with('message', [
                'type'    => 'error',
                'content' => 'حدث خطأ أثناء الاتصال ببوابة الدفع: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * صفحة العودة (Callback)
     */
    public function callback(Request $request)
    {
        // نستقبل فقط معرف الفاتورة، باقي التفاصيل تأتي من السيرفس
        $paymentRef = $request->query('payment_ref');
        // تسجيل البيانات للتأكد من وصولها (للـ Debug فقط)
        Log::info('Moyasar Callback Received', [
            'request' => $request->all()
        ]);

        if (!$paymentRef) {
            return redirect()->route('front.profile.salon.manager')->with('message', [
                'type'    => 'error',
                'content' => 'رابط العودة غير صالح.'
            ]);
        }

        // استدعاء السيرفس لمعالجة التحقق والتحديث
        $result = $this->service->handlePaymentCallback($paymentRef);

        if ($result['success']) {
            return redirect()->route('front.profile.salon.manager')->with('message', [
                'type'    => 'success',
                'content' => $result['message']
            ]);
        } else {
            return redirect()->route('front.profile.salon.manager')->with('message', [
                'type'    => 'error',
                'content' => $result['message']
            ]);
        }
    }


    public function webhook(Request $request)
    {
        Log::info('--- Webhook Handling Started ---', ['request' => $request->all()]);
        // 1. التحقق من التوقيع الرقمي (الأمان)
        $payload = $this->paymentGateway->verifyWebhook($request);

        if (!$payload) {
            Log::error('Moyasar Webhook: Invalid Signature');
            return response()->json(['message' => 'Invalid Signature'], 403);
        }

        // 2. معالجة الدفع الناجح
        if ($payload['event'] === 'invoice.paid') {
            $invoiceId = $payload['data']['id'];

            Log::info('Moyasar Webhook Received: Invoice Paid', ['invoice_id' => $invoiceId]);

            // استدعاء السيرفس لتحديث حالة الاشتراك
            $this->service->handlePaymentCallback($invoiceId);
        }

        return response()->json(['status' => 'success']);
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
