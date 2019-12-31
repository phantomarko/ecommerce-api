<?php

namespace App\Domain\Product\Model;

use App\Domain\Taxonomy\Model\Taxonomy;

class Product
{
    private $uuid;
    private $name;
    private $description;
    private $price;
    private $priceWithVat;
    private $taxonomy;

    public function __construct(
        string $uuid,
        string $name,
        string $description,
        float $price,
        float $priceWithVat,
        ?Taxonomy $taxonomy
    )
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->priceWithVat = $priceWithVat;
        $this->taxonomy = $taxonomy;
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

    public function taxonomyName(): ?string
    {
        return $this->taxonomy ? $this->taxonomy->name() : null;
    }
}