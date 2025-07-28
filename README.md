# Moneybag PHP SDK

[![Latest Version](https://img.shields.io/badge/version-v1.0.0--beta.1-orange)](https://github.com/moneybag/moneybag-sdk-php)
[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D7.4-8892BF)](https://php.net)
[![Build Status](https://img.shields.io/badge/build-passing-brightgreen)](https://github.com/moneybag/moneybag-sdk-php)

Official PHP SDK for Moneybag Payment Gateway. Simplify payment integration in your PHP applications with our easy-to-use SDK supporting checkout and payment verification.

> ⚠️ **Beta Release**: This is a beta version for testing and feedback. Not recommended for production use yet.

## Requirements

- PHP 7.4 or higher
- Composer
- Guzzle HTTP client

## Installation

### For Beta Testing

```bash
composer require moneybag/moneybag-sdk-php:^1.0@beta
```

Or add to your `composer.json`:

```json
{
    "require": {
        "moneybag/moneybag-sdk-php": "^1.0@beta"
    }
}
```

## Quick Start

### Initialize the Client

```php
use Moneybag\MoneybagClient;

// Using default base URL (staging)
$client = new MoneybagClient('your_merchant_api_key');

// Or with custom base URL (e.g., from environment variable)
$client = new MoneybagClient('your_merchant_api_key', [
    'base_url' => $_ENV['MONEYBAG_API_URL'] ?? 'https://staging.api.moneybag.com.bd/api/v2'
]);
```

### Create a Checkout Session

```php
use Moneybag\Models\CheckoutRequest;

$checkoutData = [
    'order_id' => 'order123',
    'currency' => 'BDT',
    'order_amount' => '1280.00',
    'order_description' => 'Online purchase',
    'success_url' => 'https://yourdomain.com/payment/success',
    'cancel_url' => 'https://yourdomain.com/payment/cancel',
    'fail_url' => 'https://yourdomain.com/payment/fail',
    'customer' => [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'address' => '123 Main Street',
        'city' => 'Dhaka',
        'postcode' => '1000',
        'country' => 'Bangladesh',
        'phone' => '+8801700000000'
    ]
];

try {
    $request = new CheckoutRequest($checkoutData);
    $response = $client->createCheckout($request);
    
    // Redirect customer to checkout URL
    header('Location: ' . $response->getCheckoutUrl());
} catch (MoneybagException $e) {
    // Handle error
    echo 'Error: ' . $e->getMessage();
}
```

### Verify Payment

```php
$transactionId = $_GET['transaction_id']; // Get from callback

try {
    $response = $client->verifyPayment($transactionId);
    
    if ($response->isSuccessful()) {
        // Payment successful
        echo 'Payment completed for order: ' . $response->getOrderId();
    } else {
        // Payment failed
        echo 'Payment failed with status: ' . $response->getStatus();
    }
} catch (MoneybagException $e) {
    // Handle error
    echo 'Error: ' . $e->getMessage();
}
```

## Configuration Options

```php
$client = new MoneybagClient('your_api_key', [
    'base_url' => 'https://api.moneybag.com.bd/api/v2',  // API base URL
    'timeout' => 30,                                      // Request timeout in seconds
    'verify_ssl' => true,                                 // SSL certificate verification
]);

// Or set base URL after initialization
$client->setBaseUrl('https://api.moneybag.com.bd/api/v2');
```

## Advanced Usage

### Order Items

```php
$checkoutData['order_items'] = [
    [
        'sku' => 'PROD001',
        'product_name' => 'iPhone 15',
        'product_category' => 'Electronic',
        'quantity' => 1,
        'unit_price' => '1200.00',
        'vat' => '120.00',
        'net_amount' => '1320.00'
    ]
];
```

### Shipping Information

```php
$checkoutData['shipping'] = [
    'name' => 'John Doe',
    'address' => '123 Main Street',
    'city' => 'Dhaka',
    'postcode' => '1000',
    'country' => 'Bangladesh'
];
```

### Payment Information

```php
$checkoutData['payment_info'] = [
    'is_recurring' => false,
    'installments' => 0,
    'allowed_payment_methods' => ['card', 'mobile_banking'],
    'requires_emi' => false
];
```

## Error Handling

The SDK throws specific exceptions for different error scenarios:

```php
use Moneybag\Exceptions\ValidationException;
use Moneybag\Exceptions\ApiException;
use Moneybag\Exceptions\MoneybagException;

try {
    // SDK operations
} catch (ValidationException $e) {
    // Handle validation errors
} catch (ApiException $e) {
    // Handle API errors
} catch (MoneybagException $e) {
    // Handle general SDK errors
}
```

## Testing

Run the test suite:

```bash
composer test
```

## Examples

Check the `examples` directory for complete implementation examples:

- `examples/checkout.php` - Complete checkout flow
- `examples/verify.php` - Payment verification

## Support

For support, email developer@fitl.com.bd or visit our [documentation](https://docs.moneybag.com.bd).

## Beta Version Notice

This is a **beta release** (v1.0.0-beta.1) intended for testing and feedback. 

### What to Expect
- Core functionality is complete and tested
- API may undergo minor changes before stable release
- We welcome bug reports and feature requests
- Not recommended for production use yet

### Providing Feedback
Please report issues or suggestions on our [GitHub Issues](https://github.com/moneybag/moneybag-sdk-php/issues) page.

### Roadmap to Stable Release
- [ ] Gather community feedback
- [ ] Address any reported issues
- [ ] Finalize API design
- [ ] Performance optimizations
- [ ] Additional payment method support
- [ ] Enhanced error messages

## License

This SDK is released under the MIT License. See the LICENSE file for details.
