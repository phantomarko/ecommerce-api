<?php

namespace App\Infrastructure\Product\Repository;

use App\Domain\Product\Model\Product;
use App\Domain\Product\Repository\ProductRepositoryInterface;
use App\Domain\Taxonomy\Model\Taxonomy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(ManagerRegistry $managerRegistry)
    {
        parent::__construct($managerRegistry, Product::class);
    }

    public function add(Product $product): void
    {
        $this->_em->persist($product);
    }

    public function findByFilters(
        ?Taxonomy $taxonomy,
        ?float $minimumPrice,
        ?float $maximumPrice,
        ?string $text
    ): array
    {
        $queryBuilder = $this->createQueryBuilder('p');
        if ($taxonomy) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('p.taxonomy', ':taxonomy'))
                ->setParameter('taxonomy', $taxonomy->uuid());
        }
        if ($minimumPrice) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->gte('p.price', ':minimumPrice'))
                ->setParameter('minimumPrice', $minimumPrice);
        }
        if ($maximumPrice) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->lte('p.price', ':maximumPrice'))
                ->setParameter('maximumPrice', $maximumPrice);
        }
        if ($text) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->orX(
                    $queryBuilder->expr()->like('p.name', ':name'),
                    $queryBuilder->expr()->like('p.description', ':description')
                ))
                ->setParameter('name', '%' . addcslashes($text, '%_') . '%')
                ->setParameter('description', '%' . addcslashes($text, '%_') . '%');
        }

        return $queryBuilder->getQuery()->getResult();
    }
}