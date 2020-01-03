<?php

namespace App\Application\Product\Command\CreateProduct;

class CreateProductCommand
{
    private $hostUrl;
    private $name;
    private $description;
    private $price;
    private $taxonomyUuid;
    private $base64Image;

    public function __construct(
        string $hostUrl,
        string $name,
        string $description,
        float $price,
        ?string $taxonomyUuid,
        string $base64Image
    )
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->taxonomyUuid = $taxonomyUuid;
        $this->base64Image = $base64Image;
        $this->hostUrl = $hostUrl;
    }

    public function hostUrl(): string
    {
        return $this->hostUrl;
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

    public function base64Image(): string
    {
        return $this->base64Image;
    }
}