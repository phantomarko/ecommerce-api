<?php

namespace App\Infrastructure\Product\Request;

use App\Infrastructure\Common\Request\AbstractJsonRequest;

class CreateProductRequest extends AbstractJsonRequest
{
    public function validRequest(array $request): bool
    {
        return (
            !empty($request['name'])
            && !empty($request['description'])
            && !empty($request['price'])
        );
    }

    public function name(): string
    {
        return $this->request['name'];
    }

    public function description(): string
    {
        return $this->request['description'];
    }

    public function price(): float
    {
        return $this->request['price'];
    }

    public function taxonomyUuid(): ?string
    {
        return !empty($this->request['taxonomyUuid'])
            ? $this->request['taxonomyUuid']
            : null;
    }
}