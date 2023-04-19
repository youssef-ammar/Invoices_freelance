<?php

namespace App\DTO;

class ItemCompanyItemDTO
{
    private string $nameItem;
    private string $description;
    private int $quantity;
    private float $price;
    private string $unit;

    public function __construct(
        string $nameItem,
        string $description,
        float $quantity,
        string $price,
        string $unit
    ) {
        $this->nameItem = $nameItem;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->unit = $unit;
    }

    public function getName(): string
    {
        return $this->nameItem;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }
    public function setName(string $nameItem): void
    {
        $this->nameItem = $nameItem;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function setUnit(?string $unit): void
    {
        $this->unit = $unit;
    }
}
