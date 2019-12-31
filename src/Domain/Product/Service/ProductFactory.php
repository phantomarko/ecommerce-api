<?php

namespace App\Domain\Product\Service;

use App\Domain\Common\Service\UuidGeneratorInterface;
use App\Domain\Product\Model\Product;
use App\Domain\Product\Repository\ProductRepositoryInterface;
use App\Domain\Taxonomy\Model\Taxonomy;

class ProductFactory
{
    private $productRepository;
    private $uuidGenerator;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        UuidGeneratorInterface $uuidGenerator
    )
    {
        $this->productRepository = $productRepository;
        $this->uuidGenerator = $uuidGenerator;
    }

    public function createProduct(
        string $name,
        string $description,
        float $price,
        ?Taxonomy $taxonomy
    ): Product
    {
        $product = new Product(
            $this->uuidGenerator->generate(),
            $name,
            $description,
            $price,
            $price + ($price * 0.21),
            $taxonomy
        );
        $this->productRepository->add($product);

        return $product;
    }
}