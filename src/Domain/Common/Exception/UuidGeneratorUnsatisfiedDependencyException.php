<?php

namespace App\Domain\Common\Exception;

class UuidGeneratorUnsatisfiedDependencyException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Some dependency of UuidGenerator implementation was not met.');
    }
}