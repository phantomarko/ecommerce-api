<?php

namespace App\Tests\unit\Application\Product\Command\CreateProduct;

use App\Application\Product\Command\CreateProduct\CreateProductCommand;
use PHPUnit\Framework\TestCase;

class CreateProductCommandTest extends TestCase
{
    private $hostUrl;
    private $name;
    private $description;
    private $price;
    private $taxonomyUuid;
    private $command;
    private $base64Image;

    public function setUp()
    {
        $this->hostUrl = 'http://host.example';
        $this->name = 'name';
        $this->description = 'description';
        $this->price = floatval(288);
        $this->taxonomyUuid = 'uuid';
        $this->base64Image = 'base64';

        $this->command = new CreateProductCommand(
            $this->hostUrl,
            $this->name,
            $this->description,
            $this->price,
            $this->taxonomyUuid,
            $this->base64Image
        );
    }

    public function testHostUrl()
    {
        $this->assertSame($this->command->hostUrl(), $this->hostUrl);
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
            $this->hostUrl,
            $this->name,
            $this->description,
            $this->price,
            null,
            $this->base64Image
        );

        $this->assertEmpty($command->taxonomyUuid());
    }

    public function testBase64Image()
    {
        $this->assertEquals($this->command->base64Image(), $this->base64Image);
    }
}
