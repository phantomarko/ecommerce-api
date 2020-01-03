<?php

namespace App\Domain\Common\Exception;

class Base64MimeTypeNotAllowedException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}