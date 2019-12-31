<?php

namespace App\Tests\unit\Domain\Product\Service;

use App\Domain\Common\Service\UuidGeneratorInterface;
use App\Domain\Product\Model\Product;
use App\Domain\Product\Repository\ProductRepositoryInterface;
use App\Domain\Product\Service\ProductFactory;
use PHPUnit\Framework\TestCase;

class ProductFactoryTest extends TestCase
{
    public function testCreateProduct()
    {
        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $name = 'name';
        $description = 'description';
        $price = 100;
        $priceWithVat = 121;
        $uuidGenerator = $this->prophesize(UuidGeneratorInterface::class);
        $uuidGenerator->generate()->willReturn('uuid');
        $productFactory = new ProductFactory($productRepository->reveal(), $uuidGenerator->reveal());

        $product = $productFactory->createProduct(
            $name,
            $description,
            $price,
            null
        );

        $this->assertInstanceOf(Product::class, $product);
        $this->assertIsString($product->uuid());
        $this->assertSame($product->name(), $name);
        $this->assertSame($product->description(), $description);
        $this->assertSame($product->price(), floatval($price));
        $this->assertSame($product->priceWithVat(), floatval($priceWithVat));
        $this->assertEmpty($product->taxonomyName());
    }
}
