<?php

namespace App\Infrastructure\Common\Service;

use App\Domain\Common\Service\ImageUrlGeneratorInterface;

class ExplodeImageUrlGenerator implements ImageUrlGeneratorInterface
{
    public function generate(string $hostUrl, string $imagePath): string
    {
        $imagePathParts = explode('/', $imagePath);
        return trim($hostUrl, DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR
            . 'images'
            . DIRECTORY_SEPARATOR
            . $imagePathParts[count($imagePathParts) - 1];
    }

}