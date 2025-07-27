<?php

namespace Moneybag\Models;

class PaymentInfo
{
    private bool $isRecurring = false;
    private int $installments = 0;
    private bool $currencyConversion = false;
    private array $allowedPaymentMethods = [];
    private bool $requiresEmi = false;

    public function __construct(array $data = [])
    {
        $this->isRecurring = $data['is_recurring'] ?? false;
        $this->installments = $data['installments'] ?? 0;
        $this->currencyConversion = $data['currency_conversion'] ?? false;
        $this->allowedPaymentMethods = $data['allowed_payment_methods'] ?? [];
        $this->requiresEmi = $data['requires_emi'] ?? false;
    }

    public function toArray(): array
    {
        return [
            'is_recurring' => $this->isRecurring,
            'installments' => $this->installments,
            'currency_conversion' => $this->currencyConversion,
            'allowed_payment_methods' => $this->allowedPaymentMethods,
            'requires_emi' => $this->requiresEmi,
        ];
    }
}