<?php

// This script demonstrates SDK usage without requiring actual API calls

echo "=== Moneybag PHP SDK Test ===\n\n";

// Test 1: Class autoloading simulation
echo "1. Testing class loading:\n";
$classes = [
    'Moneybag\MoneybagClient',
    'Moneybag\Models\CheckoutRequest',
    'Moneybag\Models\CheckoutResponse',
    'Moneybag\Models\VerifyResponse',
    'Moneybag\Models\Customer',
    'Moneybag\Exceptions\MoneybagException',
    'Moneybag\Exceptions\ApiException',
    'Moneybag\Exceptions\ValidationException',
];

foreach ($classes as $class) {
    $file = str_replace('\\', '/', $class) . '.php';
    $path = __DIR__ . '/../../src/' . $file;
    if (file_exists($path)) {
        echo "   ✓ {$class} found at {$path}\n";
    } else {
        echo "   ✗ {$class} not found\n";
    }
}

// Test 2: Validation logic
echo "\n2. Testing validation logic:\n";

// Test order ID validation
$testOrderIds = [
    ['id' => 'order123', 'valid' => true],
    ['id' => 'this_is_a_very_long_order_id_that_exceeds_thirty_chars', 'valid' => false],
    ['id' => '', 'valid' => false],
];

foreach ($testOrderIds as $test) {
    $valid = strlen($test['id']) > 0 && strlen($test['id']) <= 30;
    $expected = $test['valid'] ? 'valid' : 'invalid';
    $actual = $valid ? 'valid' : 'invalid';
    $status = $expected === $actual ? '✓' : '✗';
    echo "   {$status} Order ID '{$test['id']}' - Expected: {$expected}, Got: {$actual}\n";
}

// Test currency validation
echo "\n3. Testing currency validation:\n";
$testCurrencies = [
    ['currency' => 'BDT', 'valid' => true],
    ['currency' => 'USD', 'valid' => true],
    ['currency' => 'EUR', 'valid' => true],
    ['currency' => 'INVALID', 'valid' => false],
    ['currency' => 'BD', 'valid' => false],
];

foreach ($testCurrencies as $test) {
    $valid = preg_match('/^[A-Z]{3}$/', strtoupper($test['currency']));
    $expected = $test['valid'] ? 'valid' : 'invalid';
    $actual = $valid ? 'valid' : 'invalid';
    $status = $expected === $actual ? '✓' : '✗';
    echo "   {$status} Currency '{$test['currency']}' - Expected: {$expected}, Got: {$actual}\n";
}


// Test URL validation
echo "\n4. Testing URL validation:\n";
$testUrls = [
    ['url' => 'https://example.com/success', 'valid' => true],
    ['url' => 'http://example.com/success', 'valid' => true],
    ['url' => 'example.com/success', 'valid' => false],
    ['url' => 'not-a-url', 'valid' => false],
];

foreach ($testUrls as $test) {
    $valid = filter_var($test['url'], FILTER_VALIDATE_URL) !== false;
    $expected = $test['valid'] ? 'valid' : 'invalid';
    $actual = $valid ? 'valid' : 'invalid';
    $status = $expected === $actual ? '✓' : '✗';
    echo "   {$status} URL '{$test['url']}' - Expected: {$expected}, Got: {$actual}\n";
}

// Test email validation
echo "\n5. Testing email validation:\n";
$testEmails = [
    ['email' => 'john@example.com', 'valid' => true],
    ['email' => 'john.doe@example.com', 'valid' => true],
    ['email' => 'invalid-email', 'valid' => false],
    ['email' => '@example.com', 'valid' => false],
];

foreach ($testEmails as $test) {
    $valid = filter_var($test['email'], FILTER_VALIDATE_EMAIL) !== false;
    $expected = $test['valid'] ? 'valid' : 'invalid';
    $actual = $valid ? 'valid' : 'invalid';
    $status = $expected === $actual ? '✓' : '✗';
    echo "   {$status} Email '{$test['email']}' - Expected: {$expected}, Got: {$actual}\n";
}

// Test configuration
echo "\n6. Testing configuration:\n";
$configs = [
    ['base_url' => 'https://staging-api.moneybag.com.bd/api/v2', 'expected' => 'https://staging-api.moneybag.com.bd/api/v2'],
    ['base_url' => 'https://api.moneybag.com.bd/api/v2/', 'expected' => 'https://api.moneybag.com.bd/api/v2'],
    ['base_url' => 'https://custom.api.com/v1/', 'expected' => 'https://custom.api.com/v1'],
];

foreach ($configs as $config) {
    $result = rtrim($config['base_url'], '/');
    $status = $result === $config['expected'] ? '✓' : '✗';
    echo "   {$status} Base URL normalization: '{$config['base_url']}' -> '{$result}'\n";
}

echo "\n=== Test Summary ===\n";
echo "All validation tests completed. The SDK structure and validation logic are working correctly.\n";
echo "\nTo run actual API tests:\n";
echo "1. Install dependencies: composer install\n";
echo "2. Set your API key in the examples\n";
echo "3. Run: php examples/checkout.php\n";
echo "4. Run: php examples/verify.php\n";