<?php

namespace Moneybag\Models;

use Moneybag\Exceptions\ValidationException;

class Customer
{
    private string $name;
    private string $email;
    private string $address;
    private string $city;
    private string $postcode;
    private string $country;
    private string $phone;

    public function __construct(array $data)
    {
        $this->validate($data);
        
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->address = $data['address'];
        $this->city = $data['city'];
        $this->postcode = $data['postcode'];
        $this->country = $data['country'];
        $this->phone = $data['phone'];
    }

    private function validate(array $data): void
    {
        $required = ['name', 'email', 'address', 'city', 'postcode', 'country', 'phone'];
        
        foreach ($required as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                throw new ValidationException("Customer field '{$field}' is required");
            }
        }
        
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException('Invalid email format');
        }
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'city' => $this->city,
            'postcode' => $this->postcode,
            'country' => $this->country,
            'phone' => $this->phone,
        ];
    }
}