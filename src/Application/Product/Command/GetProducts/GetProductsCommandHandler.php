<?php

namespace App\Application\Product\Command\GetProducts;

use App\Application\Common\Exception\ResourceNotFoundException;
use App\Application\Product\Service\ProductToArrayConverter;
use App\Domain\Product\Repository\ProductRepositoryInterface;
use App\Domain\Taxonomy\Model\Taxonomy;
use App\Domain\Taxonomy\Repository\TaxonomyRepositoryInterface;

class GetProductsCommandHandler
{
    private $productRepository;
    private $productToArrayConverter;
    private $taxonomyRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductToArrayConverter $productToArrayConverter,
        TaxonomyRepositoryInterface $taxonomyRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->productToArrayConverter = $productToArrayConverter;
        $this->taxonomyRepository = $taxonomyRepository;
    }

    public function handle(GetProductsCommand $command)
    {
        $products = $this->productRepository->findByFilters(
            $this->getTaxonomyByUuid($command->taxonomyUuid()),
            $command->minimumPrice(),
            $command->maximumPrice(),
            $command->text()
        );

        return array_map(function ($product) {
            return $this->productToArrayConverter->toArray($product);
        }, $products);
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