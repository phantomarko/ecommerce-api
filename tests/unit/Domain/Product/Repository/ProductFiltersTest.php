<?php

namespace App\Tests\unit\Domain\Product\Repository;

use App\Domain\Product\Repository\ProductFilters;
use App\Domain\Taxonomy\Model\Taxonomy;
use PHPUnit\Framework\TestCase;

class ProductFiltersTest extends TestCase
{
    private $taxonomy;
    private $minimumPrice;
    private $maximumPrice;
    private $text;
    private $productFilters;

    public function setUp()
    {
        $this->taxonomy = $this->prophesize(Taxonomy::class);
        $this->minimumPrice = floatval(100);
        $this->maximumPrice = floatval(200);
        $this->text = 'text';
        $this->productFilters = new ProductFilters(
            $this->taxonomy->reveal(),
            $this->minimumPrice,
            $this->maximumPrice,
            $this->text
        );
    }

    public function testTaxonomy()
    {
        $this->assertEquals($this->productFilters->taxonomy(), $this->taxonomy->reveal());
    }

    public function testEmptyTaxonomy()
    {
        $productFilters = new ProductFilters(
            null,
            $this->minimumPrice,
            $this->maximumPrice,
            $this->text
        );
        $this->assertEmpty($productFilters->taxonomy());
    }

    public function testMinimumPrice()
    {
        $this->assertEquals($this->productFilters->minimumPrice(), $this->minimumPrice);
    }

    public function testEmptyMinimumPrice()
    {
        $productFilters = new ProductFilters(
            $this->taxonomy->reveal(),
            null,
            $this->maximumPrice,
            $this->text
        );
        $this->assertEmpty($productFilters->minimumPrice());
    }

    public function testMaximumPrice()
    {
        $this->assertEquals($this->productFilters->maximumPrice(), $this->maximumPrice);
    }

    public function testEmptyMaximumPrice()
    {
        $productFilters = new ProductFilters(
            $this->taxonomy->reveal(),
            $this->minimumPrice,
            null,
            $this->text
        );
        $this->assertEmpty($productFilters->maximumPrice());
    }

    public function testText()
    {
        $this->assertEquals($this->productFilters->text(), $this->text);
    }

    public function testEmptyText()
    {
        $productFilters = new ProductFilters(
            $this->taxonomy->reveal(),
            $this->minimumPrice,
            $this->maximumPrice,
            null
        );
        $this->assertEmpty($productFilters->text());
    }
}
