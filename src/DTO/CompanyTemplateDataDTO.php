<?php

namespace App\DTO;



use App\Entity\Enum\currency;
use App\Entity\Enum\language;

class CompanyTemplateDataDTO {
    public string $color;
    public string $template;
    public bool $showUnit = false;
    public bool $shopTax = false;
    public bool $showSku = false;
    public bool $dueDate = true;
    public bool $paymentMethod = true;
    public bool $productDiscount = false;
    public string $ownTextSize = "normal";
    public int $currency = language::SK;
    public int $language = currency::EUR;
    public int $defaultDueDate = 14;
    public string $defaultDeliveryDate = "TODAY";
    public bool $defaultDocumentNumberAsVariableSymbol = true;
    public string $defaultConstantSymbol;
    public int $nextInvoiceNumber = 1;
    public string $nextInvoiceNumberFormat = "RRRRCCCC"; // default format

    // constructor to set required properties
    public function __construct(
        string $color,
        string $template,
        bool $showUnit = false,
        bool $shopTax = false,
        bool $showSku = false,
        bool $dueDate = true,
        bool $paymentMethod = true,
        bool $productDiscount = false,
        string $ownTextSize = "normal",
        int $currency = language::SK,
        int $language = currency::EUR,
        int $defaultDueDate = 14,
        string $defaultDeliveryDate = "TODAY",
        bool $defaultDocumentNumberAsVariableSymbol = true,
        string $defaultConstantSymbol = "",
        int $nextInvoiceNumber = 1,
        string $nextInvoiceNumberFormat = "RRRRCCCC"
    ) {
        $this->color = $color;
        $this->template = $template;
        $this->showUnit = $showUnit;
        $this->shopTax = $shopTax;
        $this->showSku = $showSku;
        $this->dueDate = $dueDate;
        $this->paymentMethod = $paymentMethod;
        $this->productDiscount = $productDiscount;
        $this->ownTextSize = $ownTextSize;
        $this->currency = $currency;
        $this->language = $language;
        $this->defaultDueDate = $defaultDueDate;
        $this->defaultDeliveryDate = $defaultDeliveryDate;
        $this->defaultDocumentNumberAsVariableSymbol = $defaultDocumentNumberAsVariableSymbol;
        $this->defaultConstantSymbol = $defaultConstantSymbol;
        $this->nextInvoiceNumber = $nextInvoiceNumber;
        $this->nextInvoiceNumberFormat = $nextInvoiceNumberFormat;
    }
}

