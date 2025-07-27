<?php

namespace Moneybag\Models;

class OrderItem
{
    private ?string $sku = null;
    private ?string $productName = null;
    private ?string $productCategory = null;
    private ?int $quantity = null;
    private ?string $unitPrice = null;
    private ?string $vat = null;
    private ?string $convenienceFee = null;
    private ?string $discountAmount = null;
    private ?string $netAmount = null;
    private ?array $metadata = null;

    public function __construct(array $data)
    {
        $this->sku = $data['sku'] ?? null;
        $this->productName = $data['product_name'] ?? null;
        $this->productCategory = $data['product_category'] ?? null;
        $this->quantity = isset($data['quantity']) ? (int)$data['quantity'] : null;
        $this->unitPrice = $data['unit_price'] ?? null;
        $this->vat = $data['vat'] ?? null;
        $this->convenienceFee = $data['convenience_fee'] ?? null;
        $this->discountAmount = $data['discount_amount'] ?? null;
        $this->netAmount = $data['net_amount'] ?? null;
        $this->metadata = $data['metadata'] ?? null;
    }

    public function toArray(): array
    {
        $data = [];
        
        if ($this->sku !== null) $data['sku'] = $this->sku;
        if ($this->productName !== null) $data['product_name'] = $this->productName;
        if ($this->productCategory !== null) $data['product_category'] = $this->productCategory;
        if ($this->quantity !== null) $data['quantity'] = $this->quantity;
        if ($this->unitPrice !== null) $data['unit_price'] = $this->unitPrice;
        if ($this->vat !== null) $data['vat'] = $this->vat;
        if ($this->convenienceFee !== null) $data['convenience_fee'] = $this->convenienceFee;
        if ($this->discountAmount !== null) $data['discount_amount'] = $this->discountAmount;
        if ($this->netAmount !== null) $data['net_amount'] = $this->netAmount;
        if ($this->metadata !== null) $data['metadata'] = $this->metadata;
        
        return $data;
    }
}