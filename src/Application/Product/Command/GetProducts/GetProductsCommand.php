<?php

namespace App\Application\Product\Command\GetProducts;

class GetProductsCommand
{
    private $hostUrl;
    private $taxonomyUuid;
    private $minimumPrice;
    private $maximumPrice;
    private $text;
    private $page;
    private $itemsPerPage;

    public function __construct(
        string $hostUrl,
        int $page,
        int $itemsPerPage,
        ?string $taxonomyUuid,
        ?float $minimumPrice,
        ?float $maximumPrice,
        ?string $text
    )
    {
        $this->taxonomyUuid = $taxonomyUuid;
        $this->minimumPrice = $minimumPrice;
        $this->maximumPrice = $maximumPrice;
        $this->text = $text;
        $this->page = $page;
        $this->itemsPerPage = $itemsPerPage;
        $this->hostUrl = $hostUrl;
    }

    public function hostUrl(): string
    {
        return $this->hostUrl;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function itemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    public function taxonomyUuid(): ?string
    {
        return $this->taxonomyUuid;
    }

    public function minimumPrice(): ?float
    {
        return $this->minimumPrice;
    }

    public function maximumPrice(): ?float
    {
        return $this->maximumPrice;
    }

    public function text(): ?string
    {
        return $this->text;
    }
}