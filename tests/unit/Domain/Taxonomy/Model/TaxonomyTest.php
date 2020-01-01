<?php

namespace App\Tests\unit\Domain\Taxonomy\Model;

use App\Domain\Taxonomy\Model\Taxonomy;
use PHPUnit\Framework\TestCase;

class TaxonomyTest extends TestCase
{
    private $uuid;
    private $name;
    private $taxonomy;

    public function setUp()
    {
        $this->uuid = 'uuid';
        $this->name = 'name';
        $this->taxonomy = new Taxonomy($this->uuid, $this->name);
    }

    public function testUuid()
    {
        $this->assertSame($this->taxonomy->uuid(), $this->uuid);
    }

    public function testName()
    {
        $this->assertSame($this->taxonomy->name(), $this->name);
    }
}
