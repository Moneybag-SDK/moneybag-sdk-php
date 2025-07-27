<?php

namespace Moneybag\Models;

class VerifyResponse
{
    private string $transactionId;
    private string $orderId;
    private bool $verified;
    private string $status;
    private string $amount;
    private string $currency;
    private string $paymentMethod;
    private string $paymentReferenceId;
    private array $customer;

    public function __construct(array $data)
    {
        $this->transactionId = $data['transaction_id'];
        $this->orderId = $data['order_id'];
        $this->verified = $data['verified'];
        $this->status = $data['status'];
        $this->amount = $data['amount'];
        $this->currency = $data['currency'];
        $this->paymentMethod = $data['payment_method'];
        $this->paymentReferenceId = $data['payment_reference_id'];
        $this->customer = $data['customer'];
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function isVerified(): bool
    {
        return $this->verified;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    public function getPaymentReferenceId(): string
    {
        return $this->paymentReferenceId;
    }

    public function getCustomer(): array
    {
        return $this->customer;
    }

    public function isSuccessful(): bool
    {
        return $this->verified && $this->status === 'SUCCESS';
    }

    public function toArray(): array
    {
        return [
            'transaction_id' => $this->transactionId,
            'order_id' => $this->orderId,
            'verified' => $this->verified,
            'status' => $this->status,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'payment_method' => $this->paymentMethod,
            'payment_reference_id' => $this->paymentReferenceId,
            'customer' => $this->customer,
        ];
    }
}