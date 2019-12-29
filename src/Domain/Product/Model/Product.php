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
}