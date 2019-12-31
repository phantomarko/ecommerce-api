<?php

namespace App\Domain\Product\Service;

use App\Domain\Common\Service\UuidGeneratorInterface;
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

    public function __construct(
        ProductRepositoryInterface $productRepository,
        UuidGeneratorInterface $uuidGenerator,
        TaxonomyRepositoryInterface $taxonomyRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->uuidGenerator = $uuidGenerator;
        $this->taxonomyRepository = $taxonomyRepository;
    }

    public function createProduct(
        string $name,
        string $description,
        float $price,
        ?string $taxonomyUuid
    ): Product
    {
        $product = new Product(
            $this->uuidGenerator->generate(),
            $name,
            $description,
            $price,
            $price + ($price * 0.21),
            $this->getTaxonomyByUuid($taxonomyUuid)
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
}