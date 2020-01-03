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
        $hostUrl = 'url';
        $command->hostUrl()->willReturn($hostUrl);
        $name = 'name';
        $command->name()->willReturn($name);
        $description = 'description';
        $command->description()->willReturn($description);
        $price = 100;
        $command->price()->willReturn($price);
        $taxonomyUuid = 'uuid';
        $command->taxonomyUuid()->willReturn($taxonomyUuid);
        $base64Image = 'base64';
        $command->base64Image()->willReturn($base64Image);

        $product = $this->prophesize(Product::class);
        $productFactory = $this->prophesize(ProductFactory::class);
        $productFactory->createProduct(
            $name,
            $description,
            $price,
            $taxonomyUuid,
            $base64Image
        )->willReturn($product->reveal());

        $productToArrayConverter = $this->prophesize(ProductToArrayConverter::class);
        $productToArrayConverter->convert($product->reveal(), $hostUrl)->willReturn([
            'uuid' => 'uuid' // It is not necessary to return the real response
        ]);

        $handler = new CreateProductCommandHandler(
            $productFactory->reveal(),
            $productToArrayConverter->reveal()
        );
        $productArray = $handler->handle($command->reveal());

        $this->assertIsArray($productArray);
        $this->assertArrayHasKey('uuid', $productArray);
    }
}
