<?php

namespace App\Application\Product\Service;

use App\Domain\Product\Model\Product;

class ProductToArrayConverter
{
    public function toArray(Product $product): array
    {
        return [
            'uuid' => $product->uuid(),
            'name' => $product->name(),
            'description' => $product->description(),
            'price' => $product->price(),
            'priceWithVat' => $product->priceWithVat(),
            'taxonomyName' => $product->taxonomyName()
        ];
    }
}