<?php

namespace App\DTO;


use App\Entity\Enum\type;

class CompanyDataDTO
{
    private int $typeId;
    private string $name;
    private string $state;
    private string $street;
    private string $streetExtraInfo;
    private string $zip;
    private string $city;
    private string $ico;
    private string $dic;
    private string $icDph;
    private string $registryInfo;
    private string $contactName;
    private string $contactPhone;
    private string $contactEmail;
    private string $contactWeb;
    private string $logo;
    private string $signature;

    public function __construct(string $name, string $street, string $streetExtraInfo, string $zip, string $city, string $ico,
                                string $dic, string $icDph = null,
                                string $registryInfo = null,
                                string $contactName = null,
                                string $contactPhone = null,
                                string $contactEmail = null,
                                string $contactWeb = null,

                                string   $logo ,
                                string   $signature ,
                                string $state = null,
                                int    $typeId = type::NO_VAT_PAYER
    )
    {
        $this->typeId = $typeId;
        $this->name = $name;
        $this->state = $state;
        $this->street = $street;
        $this->streetExtraInfo = $streetExtraInfo;
        $this->zip = $zip;
        $this->city = $city;
        $this->ico = $ico;
        $this->dic = $dic;
        $this->icDph = $icDph;
        $this->registryInfo = $registryInfo;
        $this->contactName = $contactName;
        $this->contactPhone = $contactPhone;
        $this->contactEmail = $contactEmail;
        $this->contactWeb = $contactWeb;
        $this->logo = $logo;
        $this->signature = $signature;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    public function getStreetExtraInfo(): string
    {
        return $this->streetExtraInfo;
    }

    public function setStreetExtraInfo(string $streetExtraInfo): void
    {
        $this->streetExtraInfo = $streetExtraInfo;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function setZip(string $zip): void
    {
        $this->zip = $zip;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getIco(): string
    {
        return $this->ico;
    }

    public function setIco(string $ico): void
    {
        $this->ico = $ico;
    }

    public function getDic(): string
    {
        return $this->dic;
    }

    public function setDic(string $dic): void
    {
        $this->dic = $dic;
    }

    public function getIcDph(): ?string
    {
        return $this->icDph;
    }

    public function setIcDph(?string $icDph): void
    {
        $this->icDph = $icDph;
    }

    public function getRegistryInfo(): ?string
    {
        return $this->registryInfo;
    }

    public function setRegistryInfo(?string $registryInfo): void
    {
        $this->registryInfo = $registryInfo;
    }

    public function getContactName(): ?string
    {
        return $this->contactName;
    }

    public function setContactName(?string $contactName): void
    {
        $this->contactName = $contactName;
    }

    public function getContactPhone(): ?string
    {
        return $this->contactPhone;
    }

    public function setContactPhone(?string $contactPhone): void
    {
        $this->contactPhone = $contactPhone;

    }
    public function getTypeId(): ?int
    {
        return $this->typeId;
    }

    public function setTypeId(?int $typeId): void
    {
        $this-> typeId =  $typeId;

    }

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    public function setContactEmail(?string $contactEmail): void
    {
        $this-> typeId =  $contactEmail;

    }


    public function getContactWeb(): ?string
    {
        return $this->contactWeb;
    }

    public function setContactWeb(?string $contactWeb): void
    {
        $this->contactWeb = $contactWeb;

    }
    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): void
    {
        $this->logo = $logo;

    }
    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function setSignature(?string $signature): void
    {
        $this->signature = $signature;

    }



}

