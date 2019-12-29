<?php

namespace App\Domain\Product\Repository;

interface ProductRepositoryInterface
{
    public function findAll(): array;
}