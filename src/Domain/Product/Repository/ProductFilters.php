<?php

namespace App\Domain\Product\Repository;

use App\Domain\Taxonomy\Model\Taxonomy;

class ProductFilters
{
    private $taxonomy;
    private $minimumPrice;
    private $maximumPrice;
    private $text;

    public function __construct(
        ?Taxonomy $taxonomy,
        ?float $minimumPrice,
        ?float $maximumPrice,
        ?string $text
    )
    {
        $this->taxonomy = $taxonomy;
        $this->minimumPrice = $minimumPrice;
        $this->maximumPrice = $maximumPrice;
        $this->text = $text;
    }

    public function taxonomy(): ?Taxonomy
    {
        return $this->taxonomy;
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