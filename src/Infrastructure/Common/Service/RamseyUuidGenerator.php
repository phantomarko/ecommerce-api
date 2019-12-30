<?php

namespace App\Infrastructure\Common\Service;

use App\Domain\Common\Exception\UuidGeneratorUnsatisfiedDependencyException;
use App\Domain\Common\Service\UuidGeneratorInterface;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid;

class RamseyUuidGenerator implements UuidGeneratorInterface
{
    public function generate(): string
    {
        try {
            return (Uuid::uuid4())->toString();
        } catch (UnsatisfiedDependencyException $e) {
            throw new UuidGeneratorUnsatisfiedDependencyException();
        }
    }
}