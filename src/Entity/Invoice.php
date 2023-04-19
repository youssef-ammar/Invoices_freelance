<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $note = null;

    #[ORM\Column(nullable: true)]
    private array $companyData = [];

    #[ORM\Column(nullable: true)]
    private array $clientData = [];

    #[ORM\Column(nullable: true)]
    private array $itemsData = [];

    #[ORM\Column(nullable: true)]
    private array $paymentMethod = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getCompanyData(): array
    {
        return $this->companyData;
    }

    public function setCompanyData(?array $companyData): self
    {
        $this->companyData = $companyData;

        return $this;
    }

    public function getClientData(): array
    {
        return $this->clientData;
    }

    public function setClientData(?array $clientData): self
    {
        $this->clientData = $clientData;

        return $this;
    }

    public function getItemsData(): array
    {
        return $this->itemsData;
    }

    public function setItemsData(?array $itemsData): self
    {
        $this->itemsData = $itemsData;

        return $this;
    }

    public function getPaymentMethod(): array
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?array $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }
}
