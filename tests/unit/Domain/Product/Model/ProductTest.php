<?php

namespace App\Tests\unit\Domain\Product\Model;

use App\Domain\Product\Model\Product;
use App\Domain\Taxonomy\Model\Taxonomy;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    private $uuid;
    private $name;
    private $description;
    private $price;
    private $priceWithVat;
    private $taxonomyName;
    private $taxonomy;
    private $product;
    private $imageRelativePath;

    public function setUp()
    {
        $this->uuid = 'uuid';
        $this->name = 'name';
        $this->description = 'description';
        $this->price = 2.88;
        $this->priceWithVat = 288.88;
        $this->taxonomyName = 'taxonomy';
        $this->taxonomy = $this->prophesize(Taxonomy::class);
        $this->taxonomy->name()->willReturn($this->taxonomyName);
        $this->imageRelativePath = 'path/to/image.ext';

        $this->product = new Product(
            $this->uuid,
            $this->name,
            $this->description,
            $this->price,
            $this->priceWithVat,
            $this->taxonomy->reveal(),
            $this->imageRelativePath
        );
    }

    public function testUuid()
    {
        $this->assertSame($this->product->uuid(), $this->uuid);
    }

    public function testName()
    {
        $this->assertSame($this->product->name(), $this->name);
    }

    public function testDescription()
    {
        $this->assertSame($this->product->description(), $this->description);
    }

    public function testPrice()
    {
        $this->assertSame($this->product->price(), $this->price);
    }

    public function testPriceWithVat()
    {
        $this->assertSame($this->product->priceWithVat(), $this->priceWithVat);
    }

    public function testTaxonomyName()
    {
        $this->assertSame($this->product->taxonomyName(), $this->taxonomyName);
    }

    public function testImageRelativePath()
    {
        $this->assertSame($this->product->imagePath(), $this->imageRelativePath);
    }

    public function testEmptyTaxonomyName()
    {
        $product = new Product(
            $this->uuid,
            $this->name,
            $this->description,
            $this->price,
            $this->priceWithVat,
            null,
            $this->imageRelativePath
        );
        $this->assertEmpty($product->taxonomyName());
    }
}
