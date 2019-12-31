<?php

namespace App\Infrastructure\Product\Service;

use App\Application\Product\Command\CreateProduct\CreateProductCommand;
use App\Infrastructure\Common\Exception\InvalidSymfonyRequestException;
use Symfony\Component\HttpFoundation\Request;

class SymfonyRequestToCreateProductCommand
{
    public function convert(Request $request): CreateProductCommand
    {
        $requestDecoded = json_decode($request->getContent(), true);
        if (!is_array($requestDecoded) || !$this->isValidRequest($requestDecoded)) {
            throw new InvalidSymfonyRequestException();
        } else {
            return new CreateProductCommand(
                $requestDecoded['name'],
                $requestDecoded['description'],
                $requestDecoded['price'],
                !empty($requestDecoded['taxonomyUuid'])
                    ? $requestDecoded['taxonomyUuid']
                    : null
            );
        }
    }

    private function isValidRequest(array $request): bool
    {
        return (
            !empty($request['name'])
            && !empty($request['description'])
            && !empty($request['price'])
        );
    }
}