<?php

namespace App\Tests\unit\Application\Product\Service;

use App\Application\Product\Service\ProductToArrayConverter;
use App\Domain\Product\Model\Product;
use PHPUnit\Framework\TestCase;

class ProductToArrayConverterTest extends TestCase
{
    private $productToArrayConverter;

    public function setUp()
    {
        $this->productToArrayConverter = new ProductToArrayConverter();
    }

    public function testToArray()
    {
        $product = $this->prophesize(Product::class);
        $uuid = 'uuid';
        $product->uuid()->willReturn($uuid);
        $name = 'name';
        $product->name()->willReturn($name);
        $description = 'description';
        $product->description()->willReturn($description);
        $price = 2.88;
        $product->price()->willReturn($price);
        $priceWithVat = 288.8;
        $product->priceWithVat()->willReturn($priceWithVat);

        $array = $this->productToArrayConverter->toArray($product->reveal());

        $this->assertIsArray($array);
        $this->assertArrayHasKey('uuid', $array);
        $this->assertSame($array['uuid'], $uuid);
        $this->assertArrayHasKey('name', $array);
        $this->assertSame($array['name'], $name);
        $this->assertArrayHasKey('description', $array);
        $this->assertSame($array['description'], $description);
        $this->assertArrayHasKey('price', $array);
        $this->assertSame($array['price'], $price);
        $this->assertArrayHasKey('priceWithVat', $array);
        $this->assertSame($array['priceWithVat'], $priceWithVat);
    }
}
