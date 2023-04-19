<?php

namespace App\DTO;

class UserCompanyInvoiceCreatedReturnDataDTO
{
    private const TYPE = 'UserCompanyInvoiceCreatedReturnDataDTO';

    private string $pdfUrl;
private array $user;
private array $company;
private ItemCompanyItemDTO $item;
    private ClientDataDTO $client;

    public function __construct(string $pdfUrl, $user,$company,$item,$client)
    {
        $this->pdfUrl = $pdfUrl;
        $this->user = $user;
        $this->item = $item;
        $this->company=$company;
        $this->client = $client;

    }

    public function getType(): string
    {
        return self::TYPE;
    }

    public function getPdfUrl(): string
    {
        return $this->pdfUrl;
    }

    public function getUser(): array
    {
        return $this->user;
    }
    public function getCompany(): array
    {
        return $this->company;
    }
    public function getItem(): ItemCompanyItemDTO
    {
        return $this->item;
    }
    public function getClient():ClientDataDTO
    {
        return $this->client;
    }
}
