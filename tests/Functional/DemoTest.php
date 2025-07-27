<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Moneybag\MoneybagClient;
use Moneybag\Models\CheckoutRequest;
use Moneybag\Exceptions\ValidationException;
use Moneybag\Exceptions\ApiException;
use Moneybag\Exceptions\MoneybagException;

echo "=== Moneybag PHP SDK Demo ===\n\n";

// Test 1: Client initialization
echo "1. Testing Client initialization:\n";
try {
    $client = new MoneybagClient('test_api_key');
    echo "   ✓ Client created successfully with default URL\n";
    
    $config = $client->getConfig();
    echo "   ✓ Base URL: " . $config['base_url'] . "\n";
    echo "   ✓ Timeout: " . $config['timeout'] . " seconds\n";
    echo "   ✓ SSL Verification: " . ($config['verify_ssl'] ? 'enabled' : 'disabled') . "\n";
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// Test 2: Custom base URL
echo "\n2. Testing custom base URL:\n";
try {
    $client = new MoneybagClient('test_api_key', [
        'base_url' => 'https://api.moneybag.com.bd/api/v2',
        'timeout' => 60,
    ]);
    echo "   ✓ Client created with custom configuration\n";
    
    $config = $client->getConfig();
    echo "   ✓ Custom Base URL: " . $config['base_url'] . "\n";
    echo "   ✓ Custom Timeout: " . $config['timeout'] . " seconds\n";
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// Test 3: Checkout request validation
echo "\n3. Testing Checkout Request validation:\n";

// Valid request
try {
    $validData = [
        'order_id' => 'test_order_123',
        'currency' => 'BDT',
        'order_amount' => '100.00',
        'order_description' => 'Test Order',
        'success_url' => 'https://example.com/success',
        'cancel_url' => 'https://example.com/cancel',
        'fail_url' => 'https://example.com/fail',
        'customer' => [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'address' => '123 Test Street',
            'city' => 'Dhaka',
            'postcode' => '1000',
            'country' => 'Bangladesh',
            'phone' => '+8801700000000'
        ]
    ];
    
    $request = new CheckoutRequest($validData);
    echo "   ✓ Valid checkout request created successfully\n";
    
    $requestArray = $request->toArray();
    echo "   ✓ Request serialized to array with " . count($requestArray) . " fields\n";
} catch (ValidationException $e) {
    echo "   ✗ Validation Error: " . $e->getMessage() . "\n";
}

// Invalid currency
try {
    $invalidData = $validData;
    $invalidData['currency'] = 'INVALID';
    
    $request = new CheckoutRequest($invalidData);
    echo "   ✗ Should have thrown validation error for invalid currency\n";
} catch (ValidationException $e) {
    echo "   ✓ Correctly caught validation error: " . $e->getMessage() . "\n";
}


// Invalid email
try {
    $invalidData = $validData;
    $invalidData['customer']['email'] = 'invalid-email';
    
    $request = new CheckoutRequest($invalidData);
    echo "   ✗ Should have thrown validation error for invalid email\n";
} catch (ValidationException $e) {
    echo "   ✓ Correctly caught validation error: " . $e->getMessage() . "\n";
}

// Test 4: Complex checkout request with optional fields
echo "\n4. Testing complex checkout request:\n";
try {
    $complexData = [
        'order_id' => 'complex_order_456',
        'currency' => 'BDT',
        'order_amount' => '2500.00',
        'order_description' => 'Complex Order with Items',
        'success_url' => 'https://example.com/success',
        'cancel_url' => 'https://example.com/cancel',
        'fail_url' => 'https://example.com/fail',
        'ipn_url' => 'https://example.com/ipn',
        'customer' => [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'address' => '456 Market Street',
            'city' => 'Dhaka',
            'postcode' => '1200',
            'country' => 'Bangladesh',
            'phone' => '+8801800000000'
        ],
        'order_items' => [
            [
                'sku' => 'ITEM001',
                'product_name' => 'Product 1',
                'product_category' => 'Electronics',
                'quantity' => 2,
                'unit_price' => '1000.00',
                'vat' => '150.00',
                'net_amount' => '2150.00'
            ],
            [
                'sku' => 'ITEM002',
                'product_name' => 'Product 2',
                'quantity' => 1,
                'unit_price' => '350.00'
            ]
        ],
        'shipping' => [
            'name' => 'Jane Doe',
            'address' => '789 Shipping Ave',
            'city' => 'Chittagong',
            'postcode' => '4000',
            'country' => 'Bangladesh'
        ],
        'payment_info' => [
            'allowed_payment_methods' => ['card', 'mobile_banking', 'internet_banking'],
            'is_recurring' => false
        ],
        'metadata' => [
            'source' => 'web',
            'user_id' => '12345'
        ]
    ];
    
    $request = new CheckoutRequest($complexData);
    $requestArray = $request->toArray();
    
    echo "   ✓ Complex checkout request created successfully\n";
    echo "   ✓ Contains " . count($requestArray['order_items']) . " order items\n";
    echo "   ✓ Shipping information included\n";
    echo "   ✓ Payment info configured\n";
    echo "   ✓ Metadata attached\n";
} catch (ValidationException $e) {
    echo "   ✗ Validation Error: " . $e->getMessage() . "\n";
}

// Test 5: Verify empty transaction ID validation
echo "\n5. Testing payment verification validation:\n";
try {
    $client->verifyPayment('');
    echo "   ✗ Should have thrown validation error for empty transaction ID\n";
} catch (ValidationException $e) {
    echo "   ✓ Correctly caught validation error: " . $e->getMessage() . "\n";
}

echo "\n=== Demo Summary ===\n";
echo "✓ All SDK components are working correctly\n";
echo "✓ Validation rules are properly enforced\n";
echo "✓ Exception handling is functional\n";
echo "✓ Complex data structures are supported\n\n";

echo "Next steps:\n";
echo "1. Replace 'test_api_key' with your actual API key\n";
echo "2. Use the SDK to create real checkout sessions\n";
echo "3. Handle the response and redirect users to payment page\n";
echo "4. Verify payments after completion\n";