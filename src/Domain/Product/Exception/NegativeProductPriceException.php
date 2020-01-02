<?php

namespace App\Domain\Product\Exception;

class NegativeProductPriceException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Product price can not be negative.');
    }
}