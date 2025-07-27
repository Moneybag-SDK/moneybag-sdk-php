<?php

namespace Moneybag\Models;

class Shipping
{
    private string $name;
    private string $address;
    private string $city;
    private ?string $state = null;
    private string $postcode;
    private string $country;
    private ?array $metadata = null;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->address = $data['address'];
        $this->city = $data['city'];
        $this->state = $data['state'] ?? null;
        $this->postcode = $data['postcode'];
        $this->country = $data['country'];
        $this->metadata = $data['metadata'] ?? null;
    }

    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'postcode' => $this->postcode,
            'country' => $this->country,
        ];
        
        if ($this->state !== null) $data['state'] = $this->state;
        if ($this->metadata !== null) $data['metadata'] = $this->metadata;
        
        return $data;
    }
}