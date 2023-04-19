<?php

namespace App\DTO;



class CompanyPaymentDataDTO
{
    public BankTransfereCompanyPaymentDTO $bankTransfere;

    public PaypalCompanyPaymentDTO $paypal;
    public function __construct(BankTransfereCompanyPaymentDTO $bankTransfere,PaypalCompanyPaymentDTO $paypal){

        $this->bankTransfere=$bankTransfere;
        $this->paypal=$paypal;
    }
}
