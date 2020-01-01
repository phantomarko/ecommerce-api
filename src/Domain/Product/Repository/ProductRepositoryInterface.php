<?php

namespace App\Domain\Product\Repository;

use App\Domain\Product\Model\Product;

interface ProductRepositoryInterface
{
    public function add(Product $product): void;

    public function findByFilters(ProductFilters $filters): array;
}