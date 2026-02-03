<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface PaymentGatewayInterface
{
    /**
     * إنشاء عملية دفع جديدة وإرجاع بيانات الدفع (مع رابط الدفع المستضاف).
     *
     * @param array $data بيانات الدفع (amount, currency, description, callback_url, etc.)
     * @return array بيانات الدفع من Moyasar (id, status, url, etc.)
     * @throws Exception
     */
    public function createInvoice(array $data): array;

    /**
     * جلب حالة الدفع من Moyasar.
     *
     * @param string $paymentId
     * @return array
     * @throws Exception
     */
    public function fetchInvoice(string $invoiceId): array;

    /**
     * التحقق من توقيع Webhook وإرجاع البيانات إذا صحيح.a
     *
     * @param Request $request
     * @return array|null البيانات إذا صح التوقيع، null إذا لا
     */
    public function verifyWebhook(Request $request): ?array;
}
