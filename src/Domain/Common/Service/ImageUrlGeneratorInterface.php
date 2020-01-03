<?php

namespace App\Domain\Common\Service;

interface ImageUrlGeneratorInterface
{
    public function generate(string $hostUrl, string $imagePath): string;
}