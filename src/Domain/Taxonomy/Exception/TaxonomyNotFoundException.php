<?php

namespace App\Domain\Taxonomy\Exception;

class TaxonomyNotFoundException extends \Exception
{
    public function __construct(string $uuid)
    {
        parent::__construct('Taxonomy \'' . $uuid . '\' not found');
    }
}