<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Moneybag\MoneybagClient;
use Moneybag\Models\CheckoutRequest;
use Moneybag\Exceptions\MoneybagException;

try {
    // Initialize the Moneybag client
    // Base URL can be set from environment variable or config
    $baseUrl = $_ENV['MONEYBAG_API_URL'] ?? 'https://staging.api.moneybag.com.bd/api/v2';
    
    $client = new MoneybagClient('your_merchant_api_key', [
        'base_url' => $baseUrl,
    ]);

    // Create a checkout request
    $checkoutData = [
        'order_id' => 'order' . time(),
        'currency' => 'BDT',
        'order_amount' => '1280.00',
        'order_description' => 'Online purchase of electronics',
        'success_url' => 'https://yourdomain.com/payment/success',
        'cancel_url' => 'https://yourdomain.com/payment/cancel',
        'fail_url' => 'https://yourdomain.com/payment/fail',
        'ipn_url' => 'https://yourdomain.com/payment/ipn',
        'customer' => [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'address' => '123 Main Street',
            'city' => 'Dhaka',
            'postcode' => '1000',
            'country' => 'Bangladesh',
            'phone' => '+8801700000000'
        ],
        'order_items' => [
            [
                'sku' => 'PROD001',
                'product_name' => 'iPhone 15',
                'product_category' => 'Electronic',
                'quantity' => 1,
                'unit_price' => '1200.00',
                'vat' => '120.00',
                'convenience_fee' => '80.00',
                'discount_amount' => '100.00',
                'net_amount' => '1300.00'
            ]
        ],
        'shipping' => [
            'name' => 'John Doe',
            'address' => '123 Main Street',
            'city' => 'Dhaka',
            'postcode' => '1000',
            'country' => 'Bangladesh'
        ],
        'payment_info' => [
            'is_recurring' => false,
            'installments' => 0,
            'currency_conversion' => false,
            'allowed_payment_methods' => ['card', 'mobile_banking'],
            'requires_emi' => false
        ]
    ];

    $checkoutRequest = new CheckoutRequest($checkoutData);
    $response = $client->createCheckout($checkoutRequest);

    echo "Checkout successful!\n";
    echo "Checkout URL: " . $response->getCheckoutUrl() . "\n";
    echo "Session ID: " . $response->getSessionId() . "\n";
    echo "Expires at: " . $response->getExpiresAt() . "\n";

    // Redirect the customer to the checkout URL
    // header('Location: ' . $response->getCheckoutUrl());

} catch (MoneybagException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}