<?php

namespace App\Application\Product\Command\GetProducts;

use App\Application\Product\Service\GetProductsCommandToPaginationConverter;
use App\Application\Product\Service\GetProductsCommandToProductFiltersConverter;
use App\Application\Product\Service\ProductPaginatedResultToArrayConverter;
use App\Domain\Product\Repository\ProductRepositoryInterface;

class GetProductsCommandHandler
{
    private $productRepository;
    private $commandToProductFiltersConverter;
    private $commandToPaginationConverter;
    private $paginatedResultToArrayConverter;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        GetProductsCommandToProductFiltersConverter $commandToProductFiltersConverter,
        GetProductsCommandToPaginationConverter $commandToPaginationConverter,
        ProductPaginatedResultToArrayConverter $paginatedResultToArrayConverter
    )
    {
        $this->productRepository = $productRepository;
        $this->commandToProductFiltersConverter = $commandToProductFiltersConverter;
        $this->commandToPaginationConverter = $commandToPaginationConverter;
        $this->paginatedResultToArrayConverter = $paginatedResultToArrayConverter;
    }

    public function handle(GetProductsCommand $command)
    {
        $filters = $this->commandToProductFiltersConverter->convert($command);
        $pagination = $this->commandToPaginationConverter->convert($command);
        $productsPaginated = $this->productRepository->findPaginatedByFilters($filters, $pagination);

        return $this->paginatedResultToArrayConverter->convert($productsPaginated);
    }
}