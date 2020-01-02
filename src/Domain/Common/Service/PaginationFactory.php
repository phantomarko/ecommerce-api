<?php

namespace App\Domain\Common\Service;

use App\Domain\Common\Exception\PaginationParametersOutOfBoundsException;
use App\Domain\Common\Repository\Pagination;

class PaginationFactory
{
    public function create(int $page, int $itemsPerPage)
    {
        if ($page < 1) {
            throw new PaginationParametersOutOfBoundsException('Page value is less than one.');
        } elseif ($itemsPerPage > 100 || $itemsPerPage < 1) {
            throw new PaginationParametersOutOfBoundsException('Items per page value is outside of 1-100 range.');
        } else {
            return new Pagination($page, $itemsPerPage);
        }
    }
}