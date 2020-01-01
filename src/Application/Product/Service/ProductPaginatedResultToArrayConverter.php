<?php

namespace App\Application\Product\Service;

use App\Domain\Common\Repository\PaginatedResult;

class ProductPaginatedResultToArrayConverter
{
    private $converter;

    public function __construct(ProductToArrayConverter $converter)
    {
        $this->converter = $converter;
    }

    public function convert(PaginatedResult $paginatedResult)
    {
        return [
            'page' => $paginatedResult->page(),
            'itemsPerPage' => $paginatedResult->itemsPerPage(),
            'totalItems' => $paginatedResult->totalItems(),
            'items' => array_map(function ($product) {
                return $this->converter->toArray($product);
            }, $paginatedResult->items())
        ];
    }
}