<?php

namespace App\Domain\Product\Service;

use App\Domain\Common\Service\Base64ImageUploaderInterface;
use App\Domain\Common\Service\UuidGeneratorInterface;
use App\Domain\Product\Exception\NegativeProductPriceException;
use App\Domain\Product\Model\Product;
use App\Domain\Product\Repository\ProductRepositoryInterface;
use App\Domain\Taxonomy\Exception\TaxonomyNotFoundException;
use App\Domain\Taxonomy\Model\Taxonomy;
use App\Domain\Taxonomy\Repository\TaxonomyRepositoryInterface;

class ProductFactory
{
    private $productRepository;
    private $uuidGenerator;
    private $taxonomyRepository;
    private $base64ImageUploader;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        UuidGeneratorInterface $uuidGenerator,
        TaxonomyRepositoryInterface $taxonomyRepository,
        Base64ImageUploaderInterface $base64ImageUploader
    )
    {
        $this->productRepository = $productRepository;
        $this->uuidGenerator = $uuidGenerator;
        $this->taxonomyRepository = $taxonomyRepository;
        $this->base64ImageUploader = $base64ImageUploader;
    }

    public function createProduct(
        string $name,
        string $description,
        float $price,
        ?string $taxonomyUuid,
        string $base64Image
    ): Product
    {
        $this->validatePrice($price);
        $taxonomy = $this->getTaxonomyByUuid($taxonomyUuid);
        $uuid = $this->uuidGenerator->generate();
        $imageUploaded = $this->base64ImageUploader->upload($base64Image);
        $product = new Product(
            $uuid,
            $name,
            $description,
            $price,
            $price + ($price * 0.21),
            $taxonomy
        );
        $this->productRepository->add($product);

        return $product;
    }

    private function getTaxonomyByUuid(?string $uuid): ?Taxonomy
    {
        if (empty($uuid)) {
            return null;
        } else {
            $taxonomy = $this->taxonomyRepository->findOneByUuid($uuid);
            if (empty($taxonomy)) {
                throw new TaxonomyNotFoundException($uuid);
            } else {
                return $taxonomy;
            }
        }
    }

    private function validatePrice(float $price): void
    {
        if ($price <= 0) {
            throw new NegativeProductPriceException();
        }
    }
}