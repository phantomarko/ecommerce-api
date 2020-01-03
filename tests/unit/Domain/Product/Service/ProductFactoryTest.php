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
    private $name;
    private $description;
    private $base64Image;

    public function setUp()
    {
        $this->productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $this->uuidGenerator = $this->prophesize(UuidGeneratorInterface::class);
        $this->taxonomyRepository = $this->prophesize(TaxonomyRepositoryInterface::class);
        $this->base64ImageUploader = $this->prophesize(Base64ImageUploaderInterface::class);
        $this->name = 'name';
        $this->description = 'description';
        $this->base64Image = 'base64Image';
    }

    /**
     * @dataProvider createProductProvider
     */
    public function testCreateProduct(float $price, float $priceWithVat)
    {
        $taxonomyUuid = 'uuid';
        $taxonomy = $this->prophesize(Taxonomy::class);
        $taxonomy->name()->willReturn('taxonomy');
        $this->taxonomyRepository->findOneByUuid($taxonomyUuid)->willReturn($taxonomy->reveal());
        $imageRelativePath = 'path/to/image.ext';
        $this->base64ImageUploader->upload($this->base64Image)->willReturn($imageRelativePath);
        $this->uuidGenerator->generate()->willReturn('uuid');

        $productFactory = new ProductFactory(
            $this->productRepository->reveal(),
            $this->uuidGenerator->reveal(),
            $this->taxonomyRepository->reveal(),
            $this->base64ImageUploader->reveal()
        );

        $product = $productFactory->createProduct(
            $this->name,
            $this->description,
            $price,
            $taxonomyUuid,
            $this->base64Image
        );

        $this->assertInstanceOf(Product::class, $product);
        $this->assertNotEmpty($product->uuid());
        $this->assertSame($product->name(), $this->name);
        $this->assertSame($product->description(), $this->description);
        $this->assertSame($product->price(), floatval($price));
        $this->assertSame($product->priceWithVat(), floatval($priceWithVat));
        $this->assertNotEmpty($product->taxonomyName());
        $this->assertSame($product->imagePath(), $imageRelativePath);
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
            $this->name,
            $this->description,
            $price,
            $taxonomyUuid,
            $this->base64Image
        );
    }

    public function testCreateProductWithEmptyTaxonomyUuid()
    {
        $price = 100;
        $priceWithVat = 121;
        $this->uuidGenerator->generate()->willReturn('uuid');
        $imageRelativePath = 'path/to/image.ext';
        $this->base64ImageUploader->upload($this->base64Image)->willReturn($imageRelativePath);

        $productFactory = new ProductFactory(
            $this->productRepository->reveal(),
            $this->uuidGenerator->reveal(),
            $this->taxonomyRepository->reveal(),
            $this->base64ImageUploader->reveal()
        );

        $product = $productFactory->createProduct(
            $this->name,
            $this->description,
            $price,
            null,
            $this->base64Image
        );

        $this->assertInstanceOf(Product::class, $product);
        $this->assertIsString($product->uuid());
        $this->assertSame($product->name(), $this->name);
        $this->assertSame($product->description(), $this->description);
        $this->assertSame($product->price(), floatval($price));
        $this->assertSame($product->priceWithVat(), floatval($priceWithVat));
        $this->assertEmpty($product->taxonomyName());
        $this->assertSame($product->imagePath(), $imageRelativePath);
    }

    public function testCreateProductThrowsTaxonomyNotFoundException()
    {
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
            $this->name,
            $this->description,
            $price,
            $taxonomyUuid,
            $this->base64Image
        );
    }
}
