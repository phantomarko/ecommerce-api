<?php

namespace App\Tests\unit\Domain\Common\Service;

use App\Domain\Common\Exception\PaginationParametersOutOfBoundsException;
use App\Domain\Common\Service\PaginationFactory;
use PHPUnit\Framework\TestCase;

class PaginationFactoryTest extends TestCase
{
    private $factory;

    public function setUp()
    {
        $this->factory = new PaginationFactory();
    }

    /**
     * @dataProvider createProvider
     */
    public function testCreate(int $page, int $itemsPerPage)
    {
        $pagination = $this->factory->create($page, $itemsPerPage);

        $this->assertSame($pagination->page(), $page);
        $this->assertSame($pagination->itemsPerPage(), $itemsPerPage);
    }

    public function createProvider()
    {
        return [
            [1, 1],
            [1, 100]
        ];
    }

    /**
     * @dataProvider createThrowsExceptionProvider
     */
    public function testCreateThrowsException(int $page, int $itemsPerPage)
    {
        $this->expectException(PaginationParametersOutOfBoundsException::class);
        $this->factory->create($page, $itemsPerPage);
    }

    public function createThrowsExceptionProvider()
    {
        return [
            [0, 1],
            [1, 0],
            [1, 101]
        ];
    }
}
