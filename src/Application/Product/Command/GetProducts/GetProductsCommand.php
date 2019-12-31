<?php

namespace App\Application\Product\Command\GetProducts;

class GetProductsCommand
{
    private $taxonomyUuid;
    private $minimumPrice;
    private $maximumPrice;
    private $text;

    public function __construct(
        ?string $taxonomyUuid,
        ?float $minimumPrice,
        ?float $maximumPrice,
        ?string $text
    )
    {
        $this->taxonomyUuid = $taxonomyUuid;
        $this->minimumPrice = $minimumPrice;
        $this->maximumPrice = $maximumPrice;
        $this->text = $text;
    }

    public function taxonomyUuid(): ?string
    {
        return $this->taxonomyUuid;
    }

    public function minimumPrice(): ?float
    {
        return $this->minimumPrice;
    }

    public function maximumPrice(): ?float
    {
        return $this->maximumPrice;
    }

    public function text(): ?string
    {
        return $this->text;
    }
}