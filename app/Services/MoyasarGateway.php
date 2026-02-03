<?php

namespace App\Services;

use App\Contracts\PaymentGatewayInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MoyasarGateway implements PaymentGatewayInterface
{
    protected $client;
    protected $secretKey;
    protected $baseUrl = 'https://api.moyasar.com/v1/';

    public function __construct()
    {
        $this->secretKey = config('services.moyasar.secret_key');
        if (!$this->secretKey) {
            throw new Exception('Moyasar secret key not configured');
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

    // app/Services/MoyasarGateway.php

    public function createInvoice(array $data): array
    {
        try {
            // 1. التأكد من المبلغ بالهللة (Integer)
            $amount = (int) round($data['amount']);

            // 2. تجهيز البيانات الخاصة بالفاتورة
            $payload = [
                'amount'       => $amount,
                'currency'     => 'SAR',
                'description'  => $data['description'],
                'callback_url' => $data['callback_url'], // الرابط الذي سيعود له العميل
                'back_url'     => $data['callback_url'],
                'metadata'     => $data['metadata'] ?? [],
            ];

            Log::info('Creating Moyasar Invoice', ['payload' => $payload]);

            // 3. الطلب إلى رابط Invoices
            $response = $this->client->post('invoices', [
                'json' => $payload,
            ]);

            $result = json_decode($response->getBody()->getContents(), true);

            Log::info('Moyasar Invoice created', [
                'invoice_id' => $result['id'] ?? null,
                'url'        => $result['url'] ?? null // هذا الرابط هو الأهم
            ]);

            return $result;
        } catch (GuzzleException $e) {
            $responseBody = $e->getMessage() ? $e->getMessage() : null;
            Log::error('Moyasar Invoice creation failed', [
                'error' => $e->getMessage(),
                'response' => $responseBody,
            ]);
            throw new Exception('Failed to create invoice: ' . ($responseBody ?? $e->getMessage()));
        }
    }

    public function fetchInvoice(string $invoiceId): array
    {
        try {
            $response = $this->client->get("invoices/{$invoiceId}");
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('Moyasar fetch invoice failed', ['id' => $invoiceId]);
            throw new Exception('Failed to verify invoice');
        }
    }

    public function verifyWebhook(Request $request): ?array
    {
        $webhookSecret = config('services.moyasar.webhook_secret');
        if (!$webhookSecret) {
            Log::warning('Moyasar webhook secret not configured');
            return null;
        }

        $signature = $request->header('Moyasar-Signature');
        $payload = $request->getContent();

        $computedSignature = hash_hmac('sha256', $payload, $webhookSecret);

        if (!hash_equals($computedSignature, $signature)) {
            Log::warning('Invalid Moyasar webhook signature', ['received' => $signature]);
            return null;
        }

        Log::info('Moyasar webhook verified');

        return $request->json()->all();
    }
}
