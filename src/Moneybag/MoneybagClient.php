<?php

namespace Moneybag;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Moneybag\Exceptions\MoneybagException;
use Moneybag\Exceptions\ApiException;
use Moneybag\Exceptions\ValidationException;
use Moneybag\Models\CheckoutRequest;
use Moneybag\Models\CheckoutResponse;
use Moneybag\Models\VerifyResponse;

class MoneybagClient
{
    private const API_VERSION = 'v2';
    private const DEFAULT_TIMEOUT = 30;
    private const DEFAULT_BASE_URL = 'https://staging.api.moneybag.com.bd/api/v2';
    
    private string $apiKey;
    private string $baseUrl;
    private HttpClient $httpClient;
    private array $config;

    public function __construct(string $apiKey, array $config = [])
    {
        $this->apiKey = $apiKey;
        $this->config = array_merge([
            'base_url' => self::DEFAULT_BASE_URL,
            'timeout' => self::DEFAULT_TIMEOUT,
            'verify_ssl' => true,
        ], $config);
        
        $this->baseUrl = rtrim($this->config['base_url'], '/') . '/';
        
        $this->httpClient = new HttpClient([
            'base_uri' => $this->baseUrl,
            'timeout' => $this->config['timeout'],
            'verify' => $this->config['verify_ssl'],
            'headers' => [
                'Content-Type' => 'application/json',
                'X-Merchant-API-Key' => $this->apiKey,
            ],
        ]);
    }

    public function createCheckout(CheckoutRequest $request): CheckoutResponse
    {
        try {
            $response = $this->httpClient->post('payments/checkout', [
                'json' => $request->toArray(),
            ]);
            
            $data = json_decode($response->getBody()->getContents(), true);
            
            if (!isset($data['success']) || !$data['success']) {
                throw new ApiException($data['message'] ?? 'Checkout creation failed');
            }
            
            return new CheckoutResponse($data['data']);
            
        } catch (GuzzleException $e) {
            throw new ApiException('HTTP request failed: ' . $e->getMessage(), $e->getCode(), $e);
        } catch (\Exception $e) {
            throw new MoneybagException('Unexpected error: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    public function verifyPayment(string $transactionId): VerifyResponse
    {
        if (empty($transactionId)) {
            throw new ValidationException('Transaction ID is required');
        }
        
        try {
            $response = $this->httpClient->get('payments/verify/' . $transactionId);
            
            $data = json_decode($response->getBody()->getContents(), true);
            
            if (!isset($data['success']) || !$data['success']) {
                throw new ApiException($data['message'] ?? 'Payment verification failed');
            }
            
            return new VerifyResponse($data['data']);
            
        } catch (GuzzleException $e) {
            throw new ApiException('HTTP request failed: ' . $e->getMessage(), $e->getCode(), $e);
        } catch (\Exception $e) {
            throw new MoneybagException('Unexpected error: ' . $e->getMessage(), $e->getCode(), $e);
        }
    }

    public function setBaseUrl(string $baseUrl): self
    {
        $this->config['base_url'] = $baseUrl;
        $this->baseUrl = rtrim($baseUrl, '/') . '/';
            
        $this->httpClient = new HttpClient([
            'base_uri' => $this->baseUrl,
            'timeout' => $this->config['timeout'],
            'verify' => $this->config['verify_ssl'],
            'headers' => [
                'Content-Type' => 'application/json',
                'X-Merchant-API-Key' => $this->apiKey,
            ],
        ]);
        
        return $this;
    }

    public function getConfig(): array
    {
        return $this->config;
    }
}