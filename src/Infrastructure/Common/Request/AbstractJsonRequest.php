<?php

namespace App\Infrastructure\Common\Request;

use App\Infrastructure\Common\Exception\InvalidJsonRequestException;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractJsonRequest
{
    protected $request;

    public function __construct(Request $request)
    {
        $request = json_decode($request->getContent(), true);
        if (!is_array($request) || !$this->validRequest($request)) {
            throw new InvalidJsonRequestException();
        } else {
            $this->request = $request;
        }
    }

    abstract public function validRequest(array $request): bool;
}