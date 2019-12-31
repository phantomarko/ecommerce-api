<?php

namespace App\Application\Common\Exception;

class ResourceNotFoundException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}