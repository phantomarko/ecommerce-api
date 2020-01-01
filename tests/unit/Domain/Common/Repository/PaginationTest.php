<?php

namespace App\Tests\unit\Domain\Common\Repository;

use App\Domain\Common\Repository\Pagination;
use PHPUnit\Framework\TestCase;

class PaginationTest extends TestCase
{
    private $page;
    private $itemsPerPage;
    private $pagination;

    public function setUp()
    {
        $this->page = 1;
        $this->itemsPerPage = 10;
        $this->pagination = new Pagination($this->page, $this->itemsPerPage);
    }

    public function testPage()
    {
        $this->assertSame($this->pagination->page(), $this->page);
    }

    public function testItemsPerPage()
    {
        $this->assertSame($this->pagination->itemsPerPage(), $this->itemsPerPage);
    }
}
