<?php

namespace App\Domain\Product\Service;

use App\Domain\Product\Model\Product;
use App\Domain\Product\Repository\ProductRepositoryInterface;

class ProductFactory
{
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct(
        string $name,
        string $description,
        float $price
    ): Product
    {
        $product = new Product(
            rand(), // TODO generate uuid from injected service
            $name,
            $description,
            $price,
            $price + ($price * 0.21)
        );
        $this->productRepository->add($product);

        return $product;
    }
}