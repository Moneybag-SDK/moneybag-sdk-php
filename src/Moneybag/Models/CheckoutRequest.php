<?php

namespace Moneybag\Models;

use Moneybag\Exceptions\ValidationException;

class CheckoutRequest
{
    private string $orderId;
    private string $currency;
    private string $orderAmount;
    private string $orderDescription;
    private string $successUrl;
    private string $cancelUrl;
    private string $failUrl;
    private ?string $ipnUrl = null;
    private Customer $customer;
    private ?Shipping $shipping = null;
    private array $orderItems = [];
    private ?PaymentInfo $paymentInfo = null;
    private ?array $metadata = null;

    public function __construct(array $data)
    {
        $this->validate($data);
        
        $this->orderId = $data['order_id'];
        $this->currency = strtoupper($data['currency']);
        $this->orderAmount = $data['order_amount'];
        $this->orderDescription = $data['order_description'];
        $this->successUrl = $data['success_url'];
        $this->cancelUrl = $data['cancel_url'];
        $this->failUrl = $data['fail_url'];
        $this->ipnUrl = $data['ipn_url'] ?? null;
        
        $this->customer = new Customer($data['customer']);
        
        if (isset($data['shipping'])) {
            $this->shipping = new Shipping($data['shipping']);
        }
        
        if (isset($data['order_items'])) {
            foreach ($data['order_items'] as $item) {
                $this->orderItems[] = new OrderItem($item);
            }
        }
        
        if (isset($data['payment_info'])) {
            $this->paymentInfo = new PaymentInfo($data['payment_info']);
        }
        
        $this->metadata = $data['metadata'] ?? null;
    }

    private function validate(array $data): void
    {
        $required = ['order_id', 'currency', 'order_amount', 'order_description', 'success_url', 'cancel_url', 'fail_url', 'customer'];
        
        foreach ($required as $field) {
            if (!isset($data[$field]) || (is_string($data[$field]) && empty($data[$field]))) {
                throw new ValidationException("Field '{$field}' is required");
            }
        }
        
        if (strlen($data['order_id']) > 30) {
            throw new ValidationException('Order ID must not exceed 30 characters');
        }
        
        if (!preg_match('/^[A-Z]{3}$/', strtoupper($data['currency']))) {
            throw new ValidationException('Currency must be a three-letter code (e.g., BDT, USD, EUR)');
        }
        
        $urls = ['success_url', 'cancel_url', 'fail_url'];
        if (isset($data['ipn_url'])) {
            $urls[] = 'ipn_url';
        }
        
        foreach ($urls as $urlField) {
            if (isset($data[$urlField]) && !filter_var($data[$urlField], FILTER_VALIDATE_URL)) {
                throw new ValidationException("Invalid URL format for '{$urlField}'");
            }
        }
    }

    public function toArray(): array
    {
        $data = [
            'order_id' => $this->orderId,
            'currency' => $this->currency,
            'order_amount' => $this->orderAmount,
            'order_description' => $this->orderDescription,
            'success_url' => $this->successUrl,
            'cancel_url' => $this->cancelUrl,
            'fail_url' => $this->failUrl,
            'customer' => $this->customer->toArray(),
        ];
        
        if ($this->ipnUrl !== null) {
            $data['ipn_url'] = $this->ipnUrl;
        }
        
        if ($this->shipping !== null) {
            $data['shipping'] = $this->shipping->toArray();
        }
        
        if (!empty($this->orderItems)) {
            $data['order_items'] = array_map(function($item) {
                return $item->toArray();
            }, $this->orderItems);
        }
        
        if ($this->paymentInfo !== null) {
            $data['payment_info'] = $this->paymentInfo->toArray();
        }
        
        if ($this->metadata !== null) {
            $data['metadata'] = $this->metadata;
        }
        
        return $data;
    }
}