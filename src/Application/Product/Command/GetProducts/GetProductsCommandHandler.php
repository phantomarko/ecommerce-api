<?php

namespace App\Application\Product\Command\GetProducts;

use App\Application\Product\Service\ProductToArrayConverter;
use App\Domain\Product\Repository\ProductRepositoryInterface;

class GetProductsCommandHandler
{
    private $productRepository;
    private $productToArrayConverter;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductToArrayConverter $productToArrayConverter
    )
    {
        $this->productRepository = $productRepository;
        $this->productToArrayConverter = $productToArrayConverter;
    }

    public function handle(GetProductsCommand $command)
    {
        // TODO Get command props and use filter repository function
        return array_map(function ($product) {
            return $this->productToArrayConverter->toArray($product);
        }, $this->productRepository->findAll());
    }
}