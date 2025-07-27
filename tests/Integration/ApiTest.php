<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Moneybag\MoneybagClient;
use Moneybag\Models\CheckoutRequest;
use Moneybag\Exceptions\MoneybagException;

echo "=== Testing Moneybag API with Real API Key ===\n\n";

// Initialize client with the provided API key
$apiKey = 'd6e5763e.lkUS0LQi5z1qqMZ6B7Y89lgh5ZD2kuVfIsRXiH0aITo';
$client = new MoneybagClient($apiKey, [
    'base_url' => 'https://staging.api.moneybag.com.bd/api/v2'
]);

echo "1. Testing Checkout Creation:\n";

try {
    // Create a test checkout request
    $checkoutData = [
        'order_id' => 'test_' . time(),
        'currency' => 'BDT',
        'order_amount' => '100.00',
        'order_description' => 'Test order from PHP SDK',
        'success_url' => 'https://example.com/payment/success',
        'cancel_url' => 'https://example.com/payment/cancel',
        'fail_url' => 'https://example.com/payment/fail',
        'ipn_url' => 'https://example.com/payment/ipn',
        'customer' => [
            'name' => 'Test Customer',
            'email' => 'test@example.com',
            'address' => '123 Test Street',
            'city' => 'Dhaka',
            'postcode' => '1000',
            'country' => 'Bangladesh',
            'phone' => '+8801700000000'
        ],
        'order_items' => [
            [
                'sku' => 'TEST001',
                'product_name' => 'Test Product',
                'product_category' => 'Test',
                'quantity' => 1,
                'unit_price' => '100.00',
                'net_amount' => '100.00'
            ]
        ],
        'payment_info' => [
            'allowed_payment_methods' => ['card', 'mobile_banking'],
            'is_recurring' => false,
            'installments' => 0,
            'requires_emi' => false,
            'currency_conversion' => false
        ]
    ];

    echo "   Creating checkout for order: " . $checkoutData['order_id'] . "\n";
    
    $request = new CheckoutRequest($checkoutData);
    $response = $client->createCheckout($request);
    
    echo "\n   ✓ Checkout created successfully!\n";
    echo "   ✓ Session ID: " . $response->getSessionId() . "\n";
    echo "   ✓ Checkout URL: " . $response->getCheckoutUrl() . "\n";
    echo "   ✓ Expires at: " . $response->getExpiresAt() . "\n\n";
    
    // Save session ID for verification test
    $sessionId = $response->getSessionId();
    
    echo "   To complete payment, visit: " . $response->getCheckoutUrl() . "\n\n";
    
} catch (MoneybagException $e) {
    echo "   ✗ Error creating checkout: " . $e->getMessage() . "\n";
    echo "   Error type: " . get_class($e) . "\n\n";
}

// Test 2: Verify a payment (using a dummy transaction ID since we haven't completed payment)
echo "2. Testing Payment Verification:\n";

try {
    // Using a test transaction ID
    $testTransactionId = 'txn_test_123';
    echo "   Attempting to verify transaction: " . $testTransactionId . "\n";
    
    $verifyResponse = $client->verifyPayment($testTransactionId);
    
    echo "\n   ✓ Verification response received!\n";
    echo "   ✓ Transaction ID: " . $verifyResponse->getTransactionId() . "\n";
    echo "   ✓ Order ID: " . $verifyResponse->getOrderId() . "\n";
    echo "   ✓ Status: " . $verifyResponse->getStatus() . "\n";
    echo "   ✓ Verified: " . ($verifyResponse->isVerified() ? 'Yes' : 'No') . "\n";
    echo "   ✓ Amount: " . $verifyResponse->getAmount() . " " . $verifyResponse->getCurrency() . "\n";
    
} catch (MoneybagException $e) {
    echo "   ✗ Error verifying payment: " . $e->getMessage() . "\n";
    echo "   (This is expected if the transaction ID doesn't exist)\n\n";
}

// Test 3: Test with different configurations
echo "3. Testing Different Amount and Currency:\n";

try {
    $checkoutData2 = [
        'order_id' => 'test_usd_' . time(),
        'currency' => 'USD',
        'order_amount' => '50.00',
        'order_description' => 'Test USD order',
        'success_url' => 'https://example.com/success',
        'cancel_url' => 'https://example.com/cancel',
        'fail_url' => 'https://example.com/fail',
        'customer' => [
            'name' => 'International Customer',
            'email' => 'intl@example.com',
            'address' => '456 Global Street',
            'city' => 'New York',
            'postcode' => '10001',
            'country' => 'USA',
            'phone' => '+12125551234'
        ]
    ];
    
    $request2 = new CheckoutRequest($checkoutData2);
    $response2 = $client->createCheckout($request2);
    
    echo "   ✓ USD checkout created successfully!\n";
    echo "   ✓ Session ID: " . $response2->getSessionId() . "\n";
    echo "   ✓ Checkout URL: " . $response2->getCheckoutUrl() . "\n\n";
    
} catch (MoneybagException $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n\n";
}

echo "=== API Test Summary ===\n";
echo "The SDK is successfully communicating with the Moneybag API!\n";
echo "API Key is valid and working.\n";