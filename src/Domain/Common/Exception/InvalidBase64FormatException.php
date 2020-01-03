<?php

namespace App\Domain\Common\Exception;

class InvalidBase64FormatException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Invalid base 64 format.');
    }
}