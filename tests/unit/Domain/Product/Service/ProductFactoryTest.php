<?php

namespace App\Tests\unit\Domain\Product\Service;

use App\Domain\Common\Service\UuidGeneratorInterface;
use App\Domain\Product\Model\Product;
use App\Domain\Product\Repository\ProductRepositoryInterface;
use App\Domain\Product\Service\ProductFactory;
use App\Domain\Taxonomy\Exception\TaxonomyNotFoundException;
use App\Domain\Taxonomy\Model\Taxonomy;
use App\Domain\Taxonomy\Repository\TaxonomyRepositoryInterface;
use PHPUnit\Framework\TestCase;

class ProductFactoryTest extends TestCase
{
    private $productRepository;
    private $uuidGenerator;
    private $taxonomyRepository;

    public function setUp()
    {
        $this->productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $this->uuidGenerator = $this->prophesize(UuidGeneratorInterface::class);
        $this->taxonomyRepository = $this->prophesize(TaxonomyRepositoryInterface::class);
    }

    public function testCreateProduct()
    {
        $name = 'name';
        $description = 'description';
        $price = 100;
        $priceWithVat = 121;
        $taxonomyUuid = 'uuid';
        $taxonomy = $this->prophesize(Taxonomy::class);
        $taxonomy->name()->willReturn('taxonomy');
        $this->taxonomyRepository->findOneByUuid($taxonomyUuid)->willReturn($taxonomy->reveal());
        $this->uuidGenerator->generate()->willReturn('uuid');

        $productFactory = new ProductFactory(
            $this->productRepository->reveal(),
            $this->uuidGenerator->reveal(),
            $this->taxonomyRepository->reveal()
        );

        $product = $productFactory->createProduct(
            $name,
            $description,
            $price,
            $taxonomyUuid
        );

        $this->assertInstanceOf(Product::class, $product);
        $this->assertNotEmpty($product->uuid());
        $this->assertSame($product->name(), $name);
        $this->assertSame($product->description(), $description);
        $this->assertSame($product->price(), floatval($price));
        $this->assertSame($product->priceWithVat(), floatval($priceWithVat));
        $this->assertNotEmpty($product->taxonomyName());
    }

    public function testCreateProductWithEmptyTaxonomyUuid()
    {
        $name = 'name';
        $description = 'description';
        $price = 100;
        $priceWithVat = 121;
        $this->uuidGenerator->generate()->willReturn('uuid');

        $productFactory = new ProductFactory(
            $this->productRepository->reveal(),
            $this->uuidGenerator->reveal(),
            $this->taxonomyRepository->reveal()
        );

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

    public function testCreateProductThrowsTaxonomyNotFoundException()
    {
        $name = 'name';
        $description = 'description';
        $price = 100;
        $priceWithVat = 121;
        $taxonomyUuid = 'uuid';
        $taxonomy = $this->prophesize(Taxonomy::class);
        $taxonomy->name()->willReturn('taxonomy');
        $this->taxonomyRepository->findOneByUuid($taxonomyUuid)->willReturn(null);
        $this->uuidGenerator->generate()->willReturn('uuid');

        $productFactory = new ProductFactory(
            $this->productRepository->reveal(),
            $this->uuidGenerator->reveal(),
            $this->taxonomyRepository->reveal()
        );

        $this->expectException(TaxonomyNotFoundException::class);
        $productFactory->createProduct(
            $name,
            $description,
            $price,
            $taxonomyUuid
        );
    }
}
