<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SSLCommerz Credentials
    |--------------------------------------------------------------------------
    |
    | Obtain the sandbox credentials by registering at
    | https://developer.sslcommerz.com/registration/ and the live
    | credentials from the SSLCommerz merchant panel.
    |
    */

    'store_id' => env('SSLCOMMERZ_STORE_ID'),

    'store_password' => env('SSLCOMMERZ_STORE_PASSWORD'),

    'sandbox' => env('SSLCOMMERZ_SANDBOX', true),

    'currency' => env('SSLCOMMERZ_CURRENCY', 'BDT'),

    /*
    |--------------------------------------------------------------------------
    | API Endpoints
    |--------------------------------------------------------------------------
    |
    | The Session API creates a payment session and returns the GatewayPageURL
    | the customer is redirected to. The Validation API confirms a transaction
    | before an order is marked as paid.
    |
    */

    'gateway_url' => env(
        'SSLCOMMERZ_GATEWAY_URL',
        'https://securepay.sslcommerz.com/gwprocess/v4/api.php',
    ),

    'sandbox_gateway_url' => env(
        'SSLCOMMERZ_SANDBOX_GATEWAY_URL',
        'https://sandbox.sslcommerz.com/gwprocess/v4/api.php',
    ),

    'validation_url' => env(
        'SSLCOMMERZ_VALIDATION_URL',
        'https://securepay.sslcommerz.com/validator/api/validationserverAPI.php',
    ),

    'sandbox_validation_url' => env(
        'SSLCOMMERZ_SANDBOX_VALIDATION_URL',
        'https://sandbox.sslcommerz.com/validator/api/validationserverAPI.php',
    ),

    /*
    |--------------------------------------------------------------------------
    | Callback Routes
    |--------------------------------------------------------------------------
    |
    | The named routes SSLCommerz reports back to. The IPN URL catches
    | server-to-server notifications even when the customer leaves the page.
    |
    */

    'routes' => [
        'success' => 'checkout.payment.success',
        'fail' => 'checkout.payment.fail',
        'cancel' => 'checkout.payment.cancel',
        'ipn' => 'checkout.payment.ipn',
    ],
];
