<?php

namespace App\Tests\unit\Application\Product\Command\CreateProduct;

use App\Application\Product\Command\CreateProduct\CreateProductCommand;
use App\Application\Product\Command\CreateProduct\CreateProductCommandHandler;
use App\Application\Product\Service\ProductToArrayConverter;
use App\Domain\Product\Model\Product;
use App\Domain\Product\Service\ProductFactory;
use PHPUnit\Framework\TestCase;

class CreateProductCommandHandlerTest extends TestCase
{
    public function testHandle()
    {
        $command = $this->prophesize(CreateProductCommand::class);
        $name = 'name';
        $command->name()->willReturn($name);
        $description = 'description';
        $command->description()->willReturn($description);
        $price = 100;
        $command->price()->willReturn($price);
        $taxonomyUuid = 'uuid';
        $command->taxonomyUuid()->willReturn($taxonomyUuid);

        $product = $this->prophesize(Product::class);
        $productFactory = $this->prophesize(ProductFactory::class);
        $productFactory->createProduct(
            $name,
            $description,
            $price,
            $taxonomyUuid
        )->willReturn($product->reveal());

        $productToArrayConverter = $this->prophesize(ProductToArrayConverter::class);
        $productToArrayConverter->toArray($product->reveal())->willReturn([
            'uuid' => 'uuid',
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'priceWithVat' => $price + ($price * 0.21),
            'taxonomyName' => 'taxonomy'
        ]);

        $handler = new CreateProductCommandHandler(
            $productFactory->reveal(),
            $productToArrayConverter->reveal()
        );

        $productArray = $handler->handle($command->reveal());

        $this->assertIsArray($productArray);
        $this->assertArrayHasKey('uuid', $productArray);
        $this->assertNotEmpty($productArray['uuid']);
        $this->assertArrayHasKey('name', $productArray);
        $this->assertSame($productArray['name'], $name);
        $this->assertArrayHasKey('description', $productArray);
        $this->assertSame($productArray['description'], $description);
        $this->assertArrayHasKey('price', $productArray);
        $this->assertSame($productArray['price'], $price);
        $this->assertArrayHasKey('priceWithVat', $productArray);
        $this->assertNotEmpty($productArray['priceWithVat']);
        $this->assertArrayHasKey('taxonomyName', $productArray);
        $this->assertNotEmpty($productArray['taxonomyName']);
    }
}
