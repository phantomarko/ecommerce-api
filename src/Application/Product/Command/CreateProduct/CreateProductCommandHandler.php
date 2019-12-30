<?php

namespace App\Application\Product\Command\CreateProduct;

use App\Application\Product\Service\ProductToArrayConverter;
use App\Domain\Product\Repository\ProductRepositoryInterface;
use App\Domain\Product\Service\ProductFactory;

class CreateProductCommandHandler
{
    private $productFactory;
    private $productToArrayConverter;

    public function __construct(
        ProductFactory $productFactory,
        ProductToArrayConverter $productToArrayConverter
    )
    {
        $this->productFactory = $productFactory;
        $this->productToArrayConverter = $productToArrayConverter;
    }

    public function handle(CreateProductCommand $command)
    {
        // TODO set parameters form $command
        $product = $this->productFactory->createProduct(
            'iPhone Xs',
            'iPhone Xs 64GB Space Gray',
            799.99
        );
        return $this->productToArrayConverter->toArray($product);
    }
}