<?php

namespace App\Application\Product\Service;

use App\Application\Product\Command\GetProducts\GetProductsCommand;
use App\Domain\Common\Repository\Pagination;
use App\Domain\Common\Service\PaginationFactory;

class GetProductsCommandToPaginationConverter
{
    private $paginationFactory;

    public function __construct(PaginationFactory $paginationFactory)
    {
        $this->paginationFactory = $paginationFactory;
    }

    public function convert(GetProductsCommand $command): Pagination
    {
        return $this->paginationFactory->create($command->page(), $command->itemsPerPage());
    }
}