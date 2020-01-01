<?php

namespace App\Tests\unit\Domain\Common\Repository;

use App\Domain\Common\Repository\PaginatedResult;
use PHPUnit\Framework\TestCase;

class PaginatedResultTest extends TestCase
{
    private $page;
    private $itemsPerPage;
    private $totalItems;
    private $items;
    private $paginatedResult;

    public function setUp()
    {
        $this->page = 1;
        $this->itemsPerPage = 10;
        $this->totalItems = 100;
        $this->items = [
            'item'
        ];
        $this->paginatedResult = new PaginatedResult(
            $this->page,
            $this->itemsPerPage,
            $this->totalItems,
            $this->items
        );
    }

    public function testPage()
    {
        $this->assertSame($this->paginatedResult->page(), $this->page);
    }

    public function testItemsPerPage()
    {
        $this->assertSame($this->paginatedResult->itemsPerPage(), $this->itemsPerPage);
    }

    public function testTotalItems()
    {
        $this->assertSame($this->paginatedResult->totalItems(), $this->totalItems);
    }

    public function testItems()
    {
        $this->assertSame($this->paginatedResult->items(), $this->items);
    }
}
