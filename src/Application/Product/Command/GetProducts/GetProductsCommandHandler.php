<?php

namespace App\Application\Product\Command\GetProducts;

use App\Application\Product\Service\GetProductsCommandToProductFiltersConverter;
use App\Application\Product\Service\ProductToArrayConverter;
use App\Domain\Product\Repository\ProductRepositoryInterface;

class GetProductsCommandHandler
{
    private $productRepository;
    private $productToArrayConverter;
    private $commandToProductFiltersConverter;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductToArrayConverter $productToArrayConverter,
        GetProductsCommandToProductFiltersConverter $commandToProductFiltersConverter
    )
    {
        $this->productRepository = $productRepository;
        $this->productToArrayConverter = $productToArrayConverter;
        $this->commandToProductFiltersConverter = $commandToProductFiltersConverter;
    }

    public function handle(GetProductsCommand $command)
    {
        $filters = $this->commandToProductFiltersConverter->convert($command);
        $products = $this->productRepository->findByFilters($filters);

        return array_map(function ($product) {
            return $this->productToArrayConverter->toArray($product);
        }, $products);
    }
}