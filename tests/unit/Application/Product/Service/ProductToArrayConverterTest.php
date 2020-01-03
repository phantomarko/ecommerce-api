<?php

namespace App\Tests\unit\Application\Product\Service;

use App\Application\Product\Service\ProductToArrayConverter;
use App\Domain\Common\Service\ImageUrlGeneratorInterface;
use App\Domain\Product\Model\Product;
use PHPUnit\Framework\TestCase;

class ProductToArrayConverterTest extends TestCase
{
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
        $taxonomyName = 'taxonomy';
        $product->taxonomyName()->willReturn($taxonomyName);
        $imagePath = 'taxonomy';
        $product->imageRelativePath()->willReturn($imagePath);
        $hostUrl = 'url';

        $imageUrlGenerator = $this->prophesize(ImageUrlGeneratorInterface::class);
        $imageUrlGenerator->generate($hostUrl, $imagePath)->willReturn('imageUrl');
        $productToArrayConverter = new ProductToArrayConverter($imageUrlGenerator->reveal());
        $array = $productToArrayConverter->convert($product->reveal(), $hostUrl);

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
        $this->assertArrayHasKey('taxonomyName', $array);
        $this->assertSame($array['taxonomyName'], $taxonomyName);
        $this->assertArrayHasKey('image', $array);
    }
}
