<?php

namespace App\DTO;

class BankTransfereCompanyPaymentDTO {
    public string $nameBank;
    public string $numberPrefix;
    public string $number;
    public string $code;
    public string $iban;
    public string $SWIFT;

    public function __construct(string $nameBank, string $numberPrefix, string $number, string $code, string $iban, string $SWIFT) {
        $this->nameBank = $nameBank;
        $this->numberPrefix = $numberPrefix;
        $this->number = $number;
        $this->code = $code;
        $this->iban = $iban;
        $this->SWIFT = $SWIFT;
    }
}
