<?php

namespace App\Infrastructure\Taxonomy\Repository;

use App\Domain\Taxonomy\Model\Taxonomy;
use App\Domain\Taxonomy\Repository\TaxonomyRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineTaxonomyRepository extends ServiceEntityRepository implements TaxonomyRepositoryInterface
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Taxonomy::class);
    }

    public function findOneByUuid(string $uuid): ?Taxonomy
    {
        return parent::findOneBy(['uuid' => $uuid]);
    }
}