<?php

namespace App\Domain\Taxonomy\Model;

class Taxonomy
{
    private $uuid;
    private $name;

    public function __construct(string $uuid, string $name)
    {
        $this->uuid = $uuid;
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}