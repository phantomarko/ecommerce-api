<?php

namespace App\Application\Product\Service;

use App\Application\Common\Exception\ResourceNotFoundException;
use App\Application\Product\Command\GetProducts\GetProductsCommand;
use App\Domain\Product\Repository\ProductFilters;
use App\Domain\Taxonomy\Model\Taxonomy;
use App\Domain\Taxonomy\Repository\TaxonomyRepositoryInterface;

class GetProductsCommandToProductFiltersConverter
{
    private $taxonomyRepository;

    public function __construct(TaxonomyRepositoryInterface $taxonomyRepository)
    {
        $this->taxonomyRepository = $taxonomyRepository;
    }

    public function convert(GetProductsCommand $command): ProductFilters
    {
        return new ProductFilters(
            $this->getTaxonomyByUuid($command->taxonomyUuid()),
            $command->minimumPrice(),
            $command->maximumPrice(),
            $command->text()
        );
    }

    private function getTaxonomyByUuid(?string $uuid): ?Taxonomy
    {
        if (empty($uuid)) {
            return null;
        } else {
            $taxonomy = $this->taxonomyRepository->findOneByUuid($uuid);
            if (empty($taxonomy)) {
                throw new ResourceNotFoundException('Taxonomy \'' . $uuid . '\' not found.');
            } else {
                return $taxonomy;
            }
        }
    }
}