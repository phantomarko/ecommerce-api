<?php

namespace App\Tests\unit\Domain\Product;

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
        $productFactory = new ProductFactory($productRepository->reveal());

        $product = $productFactory->createProduct(
            $name,
            $description,
            $price
        );

        $this->assertInstanceOf(Product::class, $product);
        $this->assertIsString($product->uuid());
        $this->assertSame($product->name(), $name);
        $this->assertSame($product->description(), $description);
        $this->assertSame($product->price(), floatval($price));
        $this->assertSame($product->priceWithVat(), floatval($priceWithVat));
    }
}
