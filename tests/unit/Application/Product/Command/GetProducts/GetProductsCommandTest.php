<?php

namespace App\Tests\unit\Application\Product\Command\GetProducts;

use App\Application\Product\Command\GetProducts\GetProductsCommand;
use PHPUnit\Framework\TestCase;

class GetProductsCommandTest extends TestCase
{
    private $page;
    private $itemsPerPage;

    public function setUp()
    {
        $this->page = 1;
        $this->itemsPerPage = 10;
    }

    public function testPage()
    {
        $command = new GetProductsCommand(
            $this->page,
            $this->itemsPerPage,
            null,
            null,
            null,
            null
        );
        $this->assertSame($command->page(), $this->page);
    }

    public function testItemsPerPage()
    {
        $command = new GetProductsCommand(
            $this->page,
            $this->itemsPerPage,
            null,
            null,
            null,
            null
        );
        $this->assertSame($command->itemsPerPage(), $this->itemsPerPage);
    }

    public function testTaxonomyUuid()
    {
        $taxonomyUuid = 'uuid';
        $command = new GetProductsCommand(
            $this->page,
            $this->itemsPerPage,
            $taxonomyUuid,
            null,
            null,
            null
        );
        $this->assertSame($command->taxonomyUuid(), $taxonomyUuid);
    }

    public function testMinimumPrice()
    {
        $minimumPrice = floatval(100);
        $command = new GetProductsCommand(
            $this->page,
            $this->itemsPerPage,
            null,
            $minimumPrice,
            null,
            null
        );
        $this->assertSame($command->minimumPrice(), $minimumPrice);
    }

    public function testMaximumPrice()
    {
        $maximumPrice = floatval(100);
        $command = new GetProductsCommand(
            $this->page,
            $this->itemsPerPage,
            null,
            null,
            $maximumPrice,
            null
        );
        $this->assertSame($command->maximumPrice(), $maximumPrice);
    }

    public function testText()
    {
        $text = 'text';
        $command = new GetProductsCommand(
            $this->page,
            $this->itemsPerPage,
            null,
            null,
            null,
            $text
        );
        $this->assertSame($command->text(), $text);
    }

    public function testEmptyGetters()
    {
        $command = new GetProductsCommand(
            $this->page,
            $this->itemsPerPage,
            null,
            null,
            null,
            null
        );
        $this->assertEmpty($command->taxonomyUuid());
        $this->assertEmpty($command->minimumPrice());
        $this->assertEmpty($command->maximumPrice());
        $this->assertEmpty($command->text());
    }
}
