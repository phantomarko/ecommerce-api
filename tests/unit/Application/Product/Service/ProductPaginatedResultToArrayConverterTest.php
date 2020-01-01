<?php

namespace App\Tests\unit\Application\Product\Service;

use App\Application\Product\Service\ProductPaginatedResultToArrayConverter;
use App\Application\Product\Service\ProductToArrayConverter;
use App\Domain\Common\Repository\PaginatedResult;
use App\Domain\Product\Model\Product;
use PHPUnit\Framework\TestCase;

class ProductPaginatedResultToArrayConverterTest extends TestCase
{
    public function testConvert()
    {
        $paginatedResult = $this->prophesize(PaginatedResult::class);
        $page = 1;
        $paginatedResult->page()->willReturn($page);
        $itemsPerPage = 10;
        $paginatedResult->itemsPerPage()->willReturn($itemsPerPage);
        $totalItems = 100;
        $paginatedResult->totalItems()->willReturn($totalItems);
        $product = $this->prophesize(Product::class);
        $items = [
            $product->reveal()
        ];
        $paginatedResult->items()->willReturn($items);

        $productToArrayConverter = $this->prophesize(ProductToArrayConverter::class);
        $productToArrayConverter->convert($product->reveal())->willReturn([
            'uuid' => 'uuid'
        ]);

        $paginatedResultToArrayConverter = new ProductPaginatedResultToArrayConverter(
            $productToArrayConverter->reveal()
        );
        $array = $paginatedResultToArrayConverter->convert($paginatedResult->reveal());

        $this->assertIsArray($array);
        $this->assertArrayHasKey('page', $array);
        $this->assertEquals($array['page'], $page);
        $this->assertArrayHasKey('itemsPerPage', $array);
        $this->assertEquals($array['itemsPerPage'], $itemsPerPage);
        $this->assertArrayHasKey('totalItems', $array);
        $this->assertEquals($array['totalItems'], $totalItems);
        $this->assertArrayHasKey('items', $array);
        $this->assertIsArray($array['items']);
        $this->assertCount(1, $array['items']);
    }
}
