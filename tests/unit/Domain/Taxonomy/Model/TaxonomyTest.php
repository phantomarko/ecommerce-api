<?php

namespace App\Tests\unit\Domain\Taxonomy\Model;

use App\Domain\Taxonomy\Model\Taxonomy;
use PHPUnit\Framework\TestCase;

class TaxonomyTest extends TestCase
{
    public function testName()
    {
        $uuid = 'uuid';
        $name = 'name';
        $taxonomy = new Taxonomy($uuid, $name);

        $this->assertSame($taxonomy->name(), $name);
    }
}
