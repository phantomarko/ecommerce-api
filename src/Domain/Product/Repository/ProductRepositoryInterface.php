<?php

namespace App\Domain\Product\Repository;

use App\Domain\Product\Model\Product;
use App\Domain\Taxonomy\Model\Taxonomy;

interface ProductRepositoryInterface
{
    public function add(Product $product): void;

    public function findByFilters(
        ?Taxonomy $taxonomy,
        ?float $minimumPrice,
        ?float $maximumPrice,
        ?string $text
    ): array;

    // TODO Add function to get filtered products
}