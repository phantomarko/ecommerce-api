<?php

namespace App\Domain\Product\Model;

class Product
{
    private $uuid;
    private $name;
    private $description;
    private $price;
    private $priceWithVat;

    public function __construct(
        string $uuid,
        string $name,
        string $description,
        float $price,
        float $priceWithVat
    )
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->priceWithVat = $priceWithVat;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function price(): float
    {
        return $this->price;
    }

    public function priceWithVat(): float
    {
        return $this->priceWithVat;
    }
}