<?php

namespace App\Entity;

use App\DTO\CompanyDataDTO;
use App\DTO\CompanyPaymentDataDTO;
use App\DTO\CompanyTemplateDataDTO;
use App\Repository\CompanyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private array $data;


    #[ORM\Column(nullable: true)]
    private array  $paymentData;


    #[ORM\Column(nullable: true)]
    private array $templateData;




    #[ORM\ManyToOne(inversedBy: 'companies')]
    private ?User $user = null;




    public function getId(): ?int
    {
        return $this->id;
    }
    public function getUser(): ?User
    {
        return $this->user;
    }



    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
    public function getData(): array
    {
        return $this->data;
    }

    public function setData(?array $data): self
    {
        $this->data = $data;
 return  $this;

    }

    public function getPaymentData(): array
    {
        return $this->paymentData;
    }

    public function setPaymentData(?array   $paymentData):self
    {
        $this->paymentData = $paymentData;

        return  $this;
    }

    public function getTemplateData(): array
    {
        return $this->templateData;
    }

    public function setTemplateData(?array  $templateData): self
    {
        $this->templateData = $templateData;
        return  $this;

    }




}
