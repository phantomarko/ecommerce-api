<?php

namespace App\Tests\unit\Application\Product\Command\CreateProduct;

use App\Application\Product\Command\CreateProduct\CreateProductCommand;
use PHPUnit\Framework\TestCase;

class CreateProductCommandTest extends TestCase
{
    private $name;
    private $description;
    private $price;
    private $taxonomyUuid;
    private $command;

    public function setUp()
    {
        $this->name = 'name';
        $this->description = 'description';
        $this->price = floatval(288);
        $this->taxonomyUuid = 'uuid';

        $this->command = new CreateProductCommand(
            $this->name,
            $this->description,
            $this->price,
            $this->taxonomyUuid
        );
    }

    public function testName()
    {
        $this->assertSame($this->command->name(), $this->name);
    }

    public function testDescription()
    {
        $this->assertSame($this->command->description(), $this->description);
    }

    public function testPrice()
    {
        $this->assertSame($this->command->price(), $this->price);
    }

    public function testTaxonomyUuid()
    {
        $this->assertSame($this->command->taxonomyUuid(), $this->taxonomyUuid);
    }

    public function testEmptyTaxonomyUuid()
    {
        $command = new CreateProductCommand(
            $this->name,
            $this->description,
            $this->price,
            null
        );

        $this->assertEmpty($command->taxonomyUuid());
    }
}
