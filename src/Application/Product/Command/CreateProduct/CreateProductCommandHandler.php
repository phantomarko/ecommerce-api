<?php

namespace App\Application\Product\Command\CreateProduct;

use App\Application\Product\Service\ProductToArrayConverter;;
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
        $product = $this->productFactory->createProduct(
            $command->name(),
            $command->description(),
            $command->price(),
            $command->taxonomyUuid(),
            $command->base64Image()
        );
        return $this->productToArrayConverter->convert($product, $command->hostUrl());
    }
}