<?php

namespace App\Services;

use App\Contracts\PaymentGatewayInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class MoyasarGateway implements PaymentGatewayInterface
{
    protected $client;
    protected $secretKey;
    protected $baseUrl = 'https://api.moyasar.com/v1/';

    public function __construct()
    {
        $this->secretKey = config('services.moyasar.secret_key');

        if (!$this->secretKey) {
            throw new Exception('Moyasar secret key not configured in services.php');
        }

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'auth' => [$this->secretKey, ''],
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'timeout' => 30,
        ]);
    }

    /**
     * إنشاء فاتورة (Invoice) في ميسر
     * الفاتورة تدعم مدى، فيزا، ماستركارد، و Apple Pay تلقائياً
     */
    public function createInvoice(array $data): array
    {
        try {
            $payload = [
                'amount'       => (int) round($data['amount']), // المبلغ بالهللة
                'currency'     => $data['currency'] ?? 'SAR',
                'description'  => $data['description'],
                'callback_url' => $data['callback_url'],
                'back_url'     => $data['callback_url'], // للعودة عند الإلغاء
                'metadata'     => $data['metadata'] ?? [],
            ];

            Log::info('Moyasar: Requesting Invoice creation', ['metadata' => $payload['metadata']]);

            $response = $this->client->post('invoices', [
                'json' => $payload,
            ]);

            $result = json_decode($response->getBody()->getContents(), true);

            if (isset($result['id'])) {
                Log::info('Moyasar: Invoice created successfully', ['id' => $result['id']]);
            }

            return $result;

        } catch (GuzzleException $e) {
            $errorBody =  $e->getMessage();
            Log::error('Moyasar: Invoice creation failed', [
                'error' => $errorBody
            ]);
            throw new Exception('عذراً، تعذر الاتصال ببوابة الدفع حالياً.');
        }
    }

    /**
     * جلب بيانات الفاتورة للتحقق منها (الخطوة الأهم في الأمان)
     */
    public function fetchInvoice(string $invoiceId): array
    {
        try {
            Log::debug("Moyasar: Fetching invoice data for ID: {$invoiceId}");

            $response = $this->client->get("invoices/{$invoiceId}");

            return json_decode($response->getBody()->getContents(), true);

        } catch (GuzzleException $e) {
            Log::error("Moyasar: Failed to fetch invoice {$invoiceId}", [
                'message' => $e->getMessage()
            ]);
            throw new Exception('تعذر التحقق من حالة الفاتورة من بوابة ميسر.');
        }
    }

    /**
     * التحقق من صحة طلبات الـ Webhook (التوقيع الرقمي)
     */
    public function verifyWebhook(Request $request): ?array
    {
        $webhookSecret = config('services.moyasar.webhook_secret');
        $signature = $request->header('Moyasar-Signature');
        $payload = $request->getContent();

        if (!$webhookSecret || !$signature) {
            Log::warning('Moyasar Webhook: Missing secret or signature header',['request'=>$request->all()]);
            return null;
        }

        // حساب التوقيع ومقارنته (HMAC SHA256)
        $computedSignature = hash_hmac('sha256', $payload, $webhookSecret);

        if (!hash_equals($computedSignature, $signature)) {
            Log::error('Moyasar Webhook: Invalid signature detected');
            return null;
        }

        return json_decode($payload, true);
    }
}
