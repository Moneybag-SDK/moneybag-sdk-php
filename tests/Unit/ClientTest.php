<?php

namespace Moneybag\Tests;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Moneybag\MoneybagClient;
use Moneybag\Models\CheckoutRequest;
use Moneybag\Exceptions\ApiException;
use Moneybag\Exceptions\ValidationException;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    private function createMockClient(array $responses): MoneybagClient
    {
        $mock = new MockHandler($responses);
        $handlerStack = HandlerStack::create($mock);
        
        $client = new MoneybagClient('test_api_key', [
            'base_url' => 'https://staging.api.moneybag.com.bd/api/v2',
            'handler' => $handlerStack,
        ]);
        
        return $client;
    }

    public function testCreateCheckoutSuccess()
    {
        $responseData = [
            'success' => true,
            'data' => [
                'checkout_url' => 'https://payment.moneybag.com.bd/checkout/session123',
                'session_id' => 'session123',
                'expires_at' => '2025-05-19T15:00:00Z',
            ],
            'message' => 'Checkout session created',
        ];
        
        $client = $this->createMockClient([
            new Response(200, [], json_encode($responseData)),
        ]);
        
        $checkoutData = [
            'order_id' => 'test123',
            'currency' => 'BDT',
            'order_amount' => '100.00',
            'success_url' => 'https://example.com/success',
            'cancel_url' => 'https://example.com/cancel',
            'fail_url' => 'https://example.com/fail',
            'customer' => [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'address' => 'Test Address',
                'city' => 'Dhaka',
                'postcode' => '1000',
                'country' => 'Bangladesh',
                'phone' => '+8801700000000',
            ],
        ];
        
        $request = new CheckoutRequest($checkoutData);
        $response = $client->createCheckout($request);
        
        $this->assertEquals('https://payment.moneybag.com.bd/checkout/session123', $response->getCheckoutUrl());
        $this->assertEquals('session123', $response->getSessionId());
        $this->assertEquals('2025-05-19T15:00:00Z', $response->getExpiresAt());
    }

    public function testVerifyPaymentSuccess()
    {
        $responseData = [
            'success' => true,
            'data' => [
                'transaction_id' => 'txn123',
                'order_id' => 'order123',
                'verified' => true,
                'status' => 'SUCCESS',
                'amount' => '100.00',
                'currency' => 'BDT',
                'payment_method' => 'card',
                'payment_reference_id' => 'ref123',
                'customer' => [
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                ],
            ],
            'message' => 'Payment verification successful',
        ];
        
        $client = $this->createMockClient([
            new Response(200, [], json_encode($responseData)),
        ]);
        
        $response = $client->verifyPayment('txn123');
        
        $this->assertTrue($response->isVerified());
        $this->assertEquals('SUCCESS', $response->getStatus());
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('100.00', $response->getAmount());
    }

    public function testValidationException()
    {
        $this->expectException(ValidationException::class);
        
        $client = new MoneybagClient('test_api_key');
        $client->verifyPayment('');
    }

    public function testInvalidCurrency()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Currency must be a three-letter code');
        
        $checkoutData = [
            'order_id' => 'test123',
            'currency' => 'INVALID',
            'order_amount' => '100.00',
            'success_url' => 'https://example.com/success',
            'cancel_url' => 'https://example.com/cancel',
            'fail_url' => 'https://example.com/fail',
            'customer' => [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'address' => 'Test Address',
                'city' => 'Dhaka',
                'postcode' => '1000',
                'country' => 'Bangladesh',
                'phone' => '+8801700000000',
            ],
        ];
        
        new CheckoutRequest($checkoutData);
    }
}