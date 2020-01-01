<?php

namespace App\Tests\unit\Application\Product\Command\GetProducts;

use App\Application\Product\Command\GetProducts\GetProductsCommand;
use PHPUnit\Framework\TestCase;

class GetProductsCommandTest extends TestCase
{
    public function testTaxonomyUuid()
    {
        $taxonomyUuid = 'uuid';
        $command = new GetProductsCommand(
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
