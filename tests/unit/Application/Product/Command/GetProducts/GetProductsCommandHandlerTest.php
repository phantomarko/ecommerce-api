<?php

namespace App\Tests\unit\Application\Product\Command\GetProducts;

use App\Application\Common\Service\PaginatedResultToArrayConverter;
use App\Application\Product\Command\GetProducts\GetProductsCommand;
use App\Application\Product\Command\GetProducts\GetProductsCommandHandler;
use App\Application\Product\Service\GetProductsCommandToPaginationConverter;
use App\Application\Product\Service\GetProductsCommandToProductFiltersConverter;
use App\Application\Product\Service\ProductPaginatedResultToArrayConverter;
use App\Application\Product\Service\ProductToArrayConverter;
use App\Domain\Common\Repository\PaginatedResult;
use App\Domain\Common\Repository\Pagination;
use App\Domain\Common\Service\PaginationFactory;
use App\Domain\Product\Model\Product;
use App\Domain\Product\Repository\ProductFilters;
use App\Domain\Product\Repository\ProductRepositoryInterface;
use PHPUnit\Framework\TestCase;

class GetProductsCommandHandlerTest extends TestCase
{
    public function testHandle()
    {
        $command = $this->prophesize(GetProductsCommand::class);

        $filters = $this->prophesize(ProductFilters::class);
        $commandToProductFiltersConverter = $this->prophesize(GetProductsCommandToProductFiltersConverter::class);
        $commandToProductFiltersConverter->convert($command)->willReturn($filters->reveal());

        $commandToPaginationConverter = $this->prophesize(GetProductsCommandToPaginationConverter::class);
        $pagination = $this->prophesize(Pagination::class);
        $commandToPaginationConverter->convert($command->reveal())->willReturn($pagination->reveal());

        $paginatedResult = $this->prophesize(PaginatedResult::class);
        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $productRepository->findPaginatedByFilters($filters->reveal(), $pagination->reveal())->willReturn($paginatedResult->reveal());
        $productToArrayConverter = $this->prophesize(ProductToArrayConverter::class);

        $paginatedResultToArrayConverter = $this->prophesize(ProductPaginatedResultToArrayConverter::class);
        $paginatedResultToArrayConverter->convert($paginatedResult->reveal())->willReturn([
            'page' => 1,
            'itemsPerPage' => 10,
            'totalItems' => 100,
            'items' => []
        ]);
        $handler = new GetProductsCommandHandler(
            $productRepository->reveal(),
            $commandToProductFiltersConverter->reveal(),
            $commandToPaginationConverter->reveal(),
            $paginatedResultToArrayConverter->reveal()
        );
        $productsPaginatedArray = $handler->handle($command->reveal());

        $this->assertIsArray($productsPaginatedArray);
        $this->assertArrayHasKey('page', $productsPaginatedArray);
        $this->assertArrayHasKey('itemsPerPage', $productsPaginatedArray);
        $this->assertArrayHasKey('totalItems', $productsPaginatedArray);
        $this->assertArrayHasKey('items', $productsPaginatedArray);
    }
}
