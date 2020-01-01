<?php

namespace App\Domain\Common\Exception;

class PaginationParametersOutOfBoundsException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}