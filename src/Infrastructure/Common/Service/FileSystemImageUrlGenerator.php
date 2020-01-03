<?php

namespace App\Infrastructure\Common\Service;

use App\Domain\Common\Service\ImageUrlGeneratorInterface;

class FileSystemImageUrlGenerator implements ImageUrlGeneratorInterface
{
    private $projectPath;
    private $imagesRelativePath;
    private $imagesRelativeUrl;

    public function __construct(
        string $projectPath,
        string $imagesRelativePath,
        string $imagesRelativeUrl
    )
    {
        $this->projectPath = $projectPath;
        $this->imagesRelativePath = $imagesRelativePath;
        $this->imagesRelativeUrl = $imagesRelativeUrl;
    }

    public function generate(string $hostUrl, string $imagePath): string
    {
        $search = DIRECTORY_SEPARATOR
            . trim($this->projectPath, DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR
            . trim($this->imagesRelativePath, DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR;

        $replace = DIRECTORY_SEPARATOR
            . trim($this->imagesRelativeUrl, DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR;

        $imageRelativeUrl = str_replace($search, $replace, $imagePath);

        return trim($hostUrl, DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR
            . trim($imageRelativeUrl, DIRECTORY_SEPARATOR);
    }

}