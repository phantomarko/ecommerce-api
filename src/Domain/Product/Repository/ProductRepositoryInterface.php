<?php

namespace App\Domain\Product\Repository;

use App\Domain\Common\Repository\PaginatedResult;
use App\Domain\Common\Repository\Pagination;
use App\Domain\Product\Model\Product;

interface ProductRepositoryInterface
{
    public function add(Product $product): void;

    public function findPaginatedByFilters(ProductFilters $filters, Pagination $pagination): PaginatedResult;
}