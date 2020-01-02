<?php

namespace App\Domain\Common\Service;

class MimeType
{
    private $type;
    private $subtype;

    public function __construct(string $type, string $subtype)
    {
        $this->type = $type;
        $this->subtype = $subtype;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function subtype(): string
    {
        return $this->subtype;
    }
}