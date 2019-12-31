<?php

namespace App\Infrastructure\Common\Exception;

class InvalidSymfonyRequestException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Invalid request. Check the fields.');
    }
}