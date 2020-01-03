<?php

namespace App\Tests\unit\Domain\Product\Service;

use App\Domain\Common\Service\Base64ImageUploaderInterface;
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
    private $base64ImageUploader;

    public function setUp()
    {
        $this->productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $this->uuidGenerator = $this->prophesize(UuidGeneratorInterface::class);
        $this->taxonomyRepository = $this->prophesize(TaxonomyRepositoryInterface::class);
        $this->base64ImageUploader = $this->prophesize(Base64ImageUploaderInterface::class);
    }

    /**
     * @dataProvider createProductProvider
     */
    public function testCreateProduct(float $price, float $priceWithVat)
    {
        $name = 'name';
        $description = 'description';
        $taxonomyUuid = 'uuid';
        $base64Image = 'base64';
        $taxonomy = $this->prophesize(Taxonomy::class);
        $taxonomy->name()->willReturn('taxonomy');
        $this->taxonomyRepository->findOneByUuid($taxonomyUuid)->willReturn($taxonomy->reveal());
        $imageRelativePath = 'path/to/image.ext';
        $this->base64ImageUploader->upload($base64Image)->willReturn($imageRelativePath);
        $this->uuidGenerator->generate()->willReturn('uuid');

        $productFactory = new ProductFactory(
            $this->productRepository->reveal(),
            $this->uuidGenerator->reveal(),
            $this->taxonomyRepository->reveal(),
            $this->base64ImageUploader->reveal()
        );

        $product = $productFactory->createProduct(
            $name,
            $description,
            $price,
            $taxonomyUuid,
            $base64Image
        );

        $this->assertInstanceOf(Product::class, $product);
        $this->assertNotEmpty($product->uuid());
        $this->assertSame($product->name(), $name);
        $this->assertSame($product->description(), $description);
        $this->assertSame($product->price(), floatval($price));
        $this->assertSame($product->priceWithVat(), floatval($priceWithVat));
        $this->assertNotEmpty($product->taxonomyName());
        $this->assertSame($product->imageRelativePath(), $imageRelativePath);
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
            $this->taxonomyRepository->reveal(),
            $this->base64ImageUploader->reveal()
        );

        $this->expectException(NegativeProductPriceException::class);
        $productFactory->createProduct(
            $name,
            $description,
            $price,
            $taxonomyUuid,
            'base64'
        );
    }

    public function testCreateProductWithEmptyTaxonomyUuid()
    {
        $name = 'name';
        $description = 'description';
        $price = 100;
        $priceWithVat = 121;
        $base64Image = 'base64';
        $this->uuidGenerator->generate()->willReturn('uuid');
        $imageRelativePath = 'path/to/image.ext';
        $this->base64ImageUploader->upload($base64Image)->willReturn($imageRelativePath);

        $productFactory = new ProductFactory(
            $this->productRepository->reveal(),
            $this->uuidGenerator->reveal(),
            $this->taxonomyRepository->reveal(),
            $this->base64ImageUploader->reveal()
        );

        $product = $productFactory->createProduct(
            $name,
            $description,
            $price,
            null,
            'base64'
        );

        $this->assertInstanceOf(Product::class, $product);
        $this->assertIsString($product->uuid());
        $this->assertSame($product->name(), $name);
        $this->assertSame($product->description(), $description);
        $this->assertSame($product->price(), floatval($price));
        $this->assertSame($product->priceWithVat(), floatval($priceWithVat));
        $this->assertEmpty($product->taxonomyName());
        $this->assertSame($product->imageRelativePath(), $imageRelativePath);
    }

    public function testCreateProductThrowsTaxonomyNotFoundException()
    {
        $name = 'name';
        $description = 'description';
        $price = 100;
        $taxonomyUuid = 'uuid';
        $taxonomy = $this->prophesize(Taxonomy::class);
        $taxonomy->name()->willReturn('taxonomy');
        $this->taxonomyRepository->findOneByUuid($taxonomyUuid)->willReturn(null);
        $this->uuidGenerator->generate()->willReturn('uuid');

        $productFactory = new ProductFactory(
            $this->productRepository->reveal(),
            $this->uuidGenerator->reveal(),
            $this->taxonomyRepository->reveal(),
            $this->base64ImageUploader->reveal()
        );

        $this->expectException(TaxonomyNotFoundException::class);
        $productFactory->createProduct(
            $name,
            $description,
            $price,
            $taxonomyUuid,
            'base64'
        );
    }
}
