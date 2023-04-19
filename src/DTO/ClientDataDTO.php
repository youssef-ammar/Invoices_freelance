<?php

namespace App\DTO;

class ClientDataDTO
{
    private string $nameClient;
    private string $state;
    private string $street;
    private string $zip;
    private string $city;
    public function __construct(string $nameClient, string $street,string $city , string $zip, string $state){
        $this->nameClient = $nameClient;
        $this->state = $state;
        $this->street = $street;

        $this->zip = $zip;
        $this->city = $city;
    }
    public function getName(): string
    {
        return $this->nameClient;
    }

    public function setName(string $nameClient): void
    {
        $this->nameClient = $nameClient;
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

}