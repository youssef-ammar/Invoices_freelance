<?php

namespace App\DTO;

class PaypalCompanyPaymentDTO
{
    public string $email;

    public function __construct(
        string $email,)
    {
        $this->email = $email;

    }
}