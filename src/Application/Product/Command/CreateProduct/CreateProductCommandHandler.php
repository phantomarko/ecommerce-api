<?php

namespace App\Application\Product\Command\CreateProduct;

use App\Application\Common\Exception\ResourceNotFoundException;
use App\Application\Product\Service\ProductToArrayConverter;
use App\Domain\Product\Repository\ProductRepositoryInterface;
use App\Domain\Product\Service\ProductFactory;
use App\Domain\Taxonomy\Model\Taxonomy;
use App\Domain\Taxonomy\Repository\TaxonomyRepositoryInterface;

class CreateProductCommandHandler
{
    private $productFactory;
    private $productToArrayConverter;
    private $taxonomyRepository;

    public function __construct(
        ProductFactory $productFactory,
        ProductToArrayConverter $productToArrayConverter,
        TaxonomyRepositoryInterface $taxonomyRepository
    )
    {
        $this->productFactory = $productFactory;
        $this->productToArrayConverter = $productToArrayConverter;
        $this->taxonomyRepository = $taxonomyRepository;
    }

    public function handle(CreateProductCommand $command)
    {
        // TODO set parameters form $command
        $product = $this->productFactory->createProduct(
            'iPhone Xs',
            'iPhone Xs 64GB Space Gray',
            799.99,
            $this->getTaxonomyByUuid('656853f2-2b9a-11ea-b9eb-080027c2e88e')
        );
        return $this->productToArrayConverter->toArray($product);
    }

    private function getTaxonomyByUuid(?string $uuid): ?Taxonomy
    {
        if (empty($uuid)) {
            return null;
        } else {
            $taxonomy = $this->taxonomyRepository->findOneByUuid($uuid);
            if (empty($taxonomy)) {
                throw new ResourceNotFoundException('Taxonomy \'' . $uuid . '\' not found');
            } else {
                return $taxonomy;
            }
        }
    }
}