<?php

namespace App\Application\Product\Command\CreateProduct;

use App\Application\Common\Exception\ResourceNotFoundException;
use App\Application\Product\Service\ProductToArrayConverter;;
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
        $product = $this->productFactory->createProduct(
            $command->name(),
            $command->description(),
            $command->price(),
            $this->getTaxonomyByUuid($command->taxonomyUuid())
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