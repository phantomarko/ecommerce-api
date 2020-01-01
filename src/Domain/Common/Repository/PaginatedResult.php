<?php

namespace App\Domain\Common\Repository;

class PaginatedResult
{
    private $page;
    private $itemsPerPage;
    private $totalItems;
    private $items;

    public function __construct(
        int $page,
        int $itemsPerPage,
        int $totalItems,
        array $items
    )
    {
        $this->page = $page;
        $this->itemsPerPage = $itemsPerPage;
        $this->totalItems = $totalItems;
        $this->items = $items;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function itemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    public function totalItems(): int
    {
        return $this->totalItems;
    }

    public function items(): array
    {
        return $this->items;
    }
}