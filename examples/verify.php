<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Moneybag\MoneybagClient;
use Moneybag\Exceptions\MoneybagException;

try {
    // Initialize the Moneybag client
    // Base URL can be set from environment variable or config
    $baseUrl = $_ENV['MONEYBAG_API_URL'] ?? 'https://staging.api.moneybag.com.bd/api/v2';
    
    $client = new MoneybagClient('your_merchant_api_key', [
        'base_url' => $baseUrl,
    ]);

    // Get transaction ID from query parameter or webhook
    $transactionId = $_GET['transaction_id'] ?? 'txn1234567899';

    // Verify the payment
    $response = $client->verifyPayment($transactionId);

    echo "Payment verification successful!\n";
    echo "Transaction ID: " . $response->getTransactionId() . "\n";
    echo "Order ID: " . $response->getOrderId() . "\n";
    echo "Verified: " . ($response->isVerified() ? 'Yes' : 'No') . "\n";
    echo "Status: " . $response->getStatus() . "\n";
    echo "Amount: " . $response->getAmount() . " " . $response->getCurrency() . "\n";
    echo "Payment Method: " . $response->getPaymentMethod() . "\n";
    echo "Payment successful: " . ($response->isSuccessful() ? 'Yes' : 'No') . "\n";

    // Process the payment result
    if ($response->isSuccessful()) {
        // Update order status in your database
        // Send confirmation email to customer
        // etc.
        echo "Payment completed successfully!\n";
    } else {
        echo "Payment failed or not verified.\n";
    }

} catch (MoneybagException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}