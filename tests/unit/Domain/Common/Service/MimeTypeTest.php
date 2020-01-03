<?php

namespace App\Tests\unit\Domain\Common\Service;

use App\Domain\Common\Service\MimeType;
use PHPUnit\Framework\TestCase;

class MimeTypeTest extends TestCase
{
    private $type;
    private $subtype;
    private $mimeType;

    public function setUp()
    {
        $this->type = 'image';
        $this->subtype = 'jpeg';
        $this->mimeType = new MimeType($this->type, $this->subtype);
    }

    public function testType()
    {
        $this->assertEquals($this->mimeType->type(), $this->type);
    }

    public function testSubType()
    {
        $this->assertEquals($this->mimeType->type(), $this->type);
    }
}
