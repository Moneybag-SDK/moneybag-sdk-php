<?php

namespace Moneybag\Models;

class CheckoutResponse
{
    private string $checkoutUrl;
    private string $sessionId;
    private string $expiresAt;

    public function __construct(array $data)
    {
        $this->checkoutUrl = $data['checkout_url'];
        $this->sessionId = $data['session_id'];
        $this->expiresAt = $data['expires_at'];
    }

    public function getCheckoutUrl(): string
    {
        return $this->checkoutUrl;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function getExpiresAt(): string
    {
        return $this->expiresAt;
    }

    public function toArray(): array
    {
        return [
            'checkout_url' => $this->checkoutUrl,
            'session_id' => $this->sessionId,
            'expires_at' => $this->expiresAt,
        ];
    }
}