<?php

namespace App\Tests\unit\Domain\Product\Service;

use App\Domain\Common\Service\UuidGeneratorInterface;
use App\Domain\Product\Exception\NegativeProductPriceException;
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

    /**
     * @dataProvider createProductProvider
     */
    public function testCreateProduct(float $price, float $priceWithVat)
    {
        $name = 'name';
        $description = 'description';
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

    public function createProductProvider()
    {
        return [
            [100, 121],
            [0.1, 0.121]
        ];
    }

    public function testCreateProductWithNegativePrice()
    {
        $name = 'name';
        $description = 'description';
        $price = 0;
        $taxonomyUuid = 'uuid';
        $productFactory = new ProductFactory(
            $this->productRepository->reveal(),
            $this->uuidGenerator->reveal(),
            $this->taxonomyRepository->reveal()
        );

        $this->expectException(NegativeProductPriceException::class);
        $productFactory->createProduct(
            $name,
            $description,
            $price,
            $taxonomyUuid
        );
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
