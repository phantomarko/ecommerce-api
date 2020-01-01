<?php

namespace App\Application\Product\Command\GetProducts;

use App\Application\Product\Service\GetProductsCommandToPaginationConverter;
use App\Application\Product\Service\GetProductsCommandToProductFiltersConverter;
use App\Application\Product\Service\ProductToArrayConverter;
use App\Domain\Common\Service\PaginationFactory;
use App\Domain\Product\Repository\ProductRepositoryInterface;

class GetProductsCommandHandler
{
    private $productRepository;
    private $productToArrayConverter;
    private $commandToProductFiltersConverter;
    private $commandToPaginationConverter;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductToArrayConverter $productToArrayConverter,
        GetProductsCommandToProductFiltersConverter $commandToProductFiltersConverter,
        GetProductsCommandToPaginationConverter $commandToPaginationConverter
    )
    {
        $this->productRepository = $productRepository;
        $this->productToArrayConverter = $productToArrayConverter;
        $this->commandToProductFiltersConverter = $commandToProductFiltersConverter;
        $this->commandToPaginationConverter = $commandToPaginationConverter;
    }

    public function handle(GetProductsCommand $command)
    {
        $filters = $this->commandToProductFiltersConverter->convert($command);
        $pagination = $this->commandToPaginationConverter->convert($command);
        $products = $this->productRepository->findPaginatedByFilters($filters, $pagination);

        return array_map(function ($product) {
            return $this->productToArrayConverter->toArray($product);
        }, $products);
    }
}