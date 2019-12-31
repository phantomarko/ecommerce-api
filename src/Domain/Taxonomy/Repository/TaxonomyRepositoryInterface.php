<?php

namespace App\Domain\Taxonomy\Repository;

use App\Domain\Taxonomy\Model\Taxonomy;

interface TaxonomyRepositoryInterface
{
    public function findOneByUuid(string $uuid): ?Taxonomy;
}