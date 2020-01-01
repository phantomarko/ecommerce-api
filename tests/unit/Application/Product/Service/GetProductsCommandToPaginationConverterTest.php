<?php

namespace App\Tests\unit\Application\Product\Service;

use App\Application\Product\Command\GetProducts\GetProductsCommand;
use App\Application\Product\Service\GetProductsCommandToPaginationConverter;
use App\Domain\Common\Repository\Pagination;
use App\Domain\Common\Service\PaginationFactory;
use PHPUnit\Framework\TestCase;

class GetProductsCommandToPaginationConverterTest extends TestCase
{
    public function testConvert()
    {
        $page = 1;
        $itemsPerPage = 10;
        $command = $this->prophesize(GetProductsCommand::class);
        $command->page()->willReturn($page);
        $command->itemsPerPage()->willReturn($itemsPerPage);
        $commandRevealed = $command->reveal();
        $pagination = $this->prophesize(Pagination::class);
        $factory = $this->prophesize(PaginationFactory::class);
        $factory->create($commandRevealed->page(), $commandRevealed->itemsPerPage())->willReturn($pagination->reveal());

        $converter = new GetProductsCommandToPaginationConverter($factory->reveal());
        $pagination = $converter->convert($commandRevealed);

        $this->assertInstanceOf(Pagination::class, $pagination);
    }
}
