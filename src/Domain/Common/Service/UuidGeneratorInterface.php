<?php

namespace App\Domain\Common\Service;

interface UuidGeneratorInterface
{
    public function generate(): string;
}