<?php

namespace App\Tests\unit\Application\Product\Service;

use App\Application\Common\Exception\ResourceNotFoundException;
use App\Application\Product\Command\GetProducts\GetProductsCommand;
use App\Application\Product\Service\GetProductsCommandToProductFiltersConverter;
use App\Domain\Product\Repository\ProductFilters;
use App\Domain\Taxonomy\Model\Taxonomy;
use App\Domain\Taxonomy\Repository\TaxonomyRepositoryInterface;
use PHPUnit\Framework\TestCase;

class GetProductsCommandToProductFiltersConverterTest extends TestCase
{
    private $taxonomyRepository;
    private $taxonomyUuid;
    private $command;

    public function setUp()
    {
        $this->taxonomyRepository = $this->prophesize(TaxonomyRepositoryInterface::class);
        $this->command = $this->prophesize(GetProductsCommand::class);
        $this->taxonomyUuid = 'uuid';
        $this->command->taxonomyUuid()->willReturn($this->taxonomyUuid);
        $this->command->minimumPrice()->willReturn(floatval(100));
        $this->command->maximumPrice()->willReturn(floatval(200));
        $this->command->text()->willReturn('text');
    }

    public function testConvert()
    {
        $taxonomy = $this->prophesize(Taxonomy::class);
        $this->taxonomyRepository->findOneByUuid($this->taxonomyUuid)->willReturn($taxonomy->reveal());
        $converter = new GetProductsCommandToProductFiltersConverter($this->taxonomyRepository->reveal());

        $filters = $converter->convert($this->command->reveal());

        $this->assertInstanceOf(ProductFilters::class, $filters);
        $this->assertInstanceOf(Taxonomy::class, $filters->taxonomy());
    }

    public function testConvertWithEmptyTaxonomyUuid()
    {
        $converter = new GetProductsCommandToProductFiltersConverter($this->taxonomyRepository->reveal());
        $this->command->taxonomyUuid()->willReturn(null);
        $filters = $converter->convert($this->command->reveal());

        $this->assertInstanceOf(ProductFilters::class, $filters);
        $this->assertEmpty($filters->taxonomy());
    }

    public function testConvertThrowsResourceNotFoundException()
    {
        $this->taxonomyRepository->findOneByUuid($this->taxonomyUuid)->willReturn(null);
        $converter = new GetProductsCommandToProductFiltersConverter($this->taxonomyRepository->reveal());

        $this->expectException(ResourceNotFoundException::class);
        $converter->convert($this->command->reveal());
    }
}
