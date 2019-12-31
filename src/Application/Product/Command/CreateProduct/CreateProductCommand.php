<?php

namespace App\Application\Product\Command\CreateProduct;

class CreateProductCommand
{
    private $name;
    private $description;
    private $price;
    private $taxonomyUuid;

    public function __construct(
        string $name,
        string $description,
        float $price,
        ?string $taxonomyUuid
    )
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->taxonomyUuid = $taxonomyUuid;
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

    public function taxonomyUuid(): ?string
    {
        return $this->taxonomyUuid;
    }
}