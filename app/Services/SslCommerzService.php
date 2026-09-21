<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SslCommerzService
{
    /**
     * Create a payment session and return the GatewayPageURL the customer
     * should be redirected to, or null when the session creation fails.
     */
    public function initiate(Order $order, array $customer): ?string
    {
        $response = Http::asForm()
            ->acceptJson()
            ->timeout(30)
            ->post($this->gatewayUrl(), [
                'store_id' => config('sslcommerz.store_id'),
                'store_passwd' => config('sslcommerz.store_password'),
                'total_amount' => number_format($order->order_total, 2, '.', ''),
                'currency' => $order->currency,
                'tran_id' => $order->transaction_id,
                'success_url' => route(config('sslcommerz.routes.success')),
                'fail_url' => route(config('sslcommerz.routes.fail')),
                'cancel_url' => route(config('sslcommerz.routes.cancel')),
                'ipn_url' => route(config('sslcommerz.routes.ipn')),
                'cus_name' => $this->gatewayText($customer['name']),
                'cus_email' => $customer['email'],
                'cus_add1' => $this->gatewayText($customer['address']),
                'cus_city' => 'Dhaka',
                'cus_postcode' => '1000',
                'cus_country' => 'Bangladesh',
                'cus_phone' => $customer['phone'],
                'shipping_method' => 'NO',
                'product_name' => $this->gatewayText(substr($order->details->pluck('product_name')->join(', '), 0, 255)) ?: 'Order',
                'product_category' => 'General',
                'product_profile' => 'general',
            ]);

        $payload = $response->json() ?? [];

        if ($response->successful() && ($payload['status'] ?? null) === 'SUCCESS') {
            return $payload['GatewayPageURL'] ?? null;
        }

        Log::warning('SSLCommerz session creation failed.', [
            'tran_id' => $order->transaction_id,
            'http_status' => $response->status(),
            'gateway_status' => $payload['status'] ?? null,
            'failedreason' => $payload['failedreason'] ?? null,
        ]);

        return null;
    }

    /**
     * Query the SSLCommerz Order Validation API for a transaction.
     *
     * Returns the raw payload. Callers must match the status, amount, and
     * transaction id against their own records before trusting it.
     */
    public function validate(string $valId): array
    {
        $response = Http::acceptJson()
            ->timeout(30)
            ->get($this->validationUrl(), [
                'val_id' => $valId,
                'store_id' => config('sslcommerz.store_id'),
                'store_passwd' => config('sslcommerz.store_password'),
                'format' => 'json',
            ]);

        return $response->json() ?? [];
    }

    /**
     * Verify the signature SSLCommerz includes on its IPN and redirect
     * notifications to prove the payload was not tampered with.
     *
     * Follows the official algorithm: collect the verify_key parameters,
     * add the MD5 of the store password, sort by name, join as
     * key=value pairs, and compare the MD5 hash with verify_sign.
     */
    public function verifySignature(string $verifyKey, string $verifySign, array $payload): bool
    {
        if ($verifyKey === '' || $verifySign === '') {
            return false;
        }

        $data = [];

        foreach (explode(',', $verifyKey) as $param) {
            $param = trim($param);

            if ($param === '' || $param === 'store_passwd' || ! array_key_exists($param, $payload)) {
                continue;
            }

            $value = $payload[$param];
            $data[$param] = is_scalar($value) ? (string) $value : '';
        }

        if ($data === []) {
            return false;
        }

        $data['store_passwd'] = md5((string) config('sslcommerz.store_password'));
        ksort($data);

        $hash = implode('&', array_map(fn (string $key): string => $key.'='.$data[$key], array_keys($data)));

        return hash_equals(md5($hash), strtolower($verifySign));
    }

    /**
     * Strip double quotes from free text sent to the gateway.
     *
     * The session API answers HTTP 500 with an empty body when a field
     * such as product_name contains a double quote (e.g. a 31.5" monitor),
     * which surfaces as a silent redirect back to checkout.
     */
    private function gatewayText(string $value): string
    {
        return trim(str_replace('"', '', $value));
    }

    private function gatewayUrl(): string
    {
        return config('sslcommerz.sandbox')
            ? config('sslcommerz.sandbox_gateway_url')
            : config('sslcommerz.gateway_url');
    }

    private function validationUrl(): string
    {
        return config('sslcommerz.sandbox')
            ? config('sslcommerz.sandbox_validation_url')
            : config('sslcommerz.validation_url');
    }
}
