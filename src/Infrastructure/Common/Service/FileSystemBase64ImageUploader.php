<?php

namespace App\Infrastructure\Common\Service;

use App\Domain\Common\Exception\InvalidBase64FormatException;
use App\Domain\Common\Service\Base64ImageUploaderInterface;
use App\Domain\Common\Service\Base64ToMimeTypeConverterInterface;
use App\Domain\Common\Service\MimeType;
use App\Domain\Common\Service\UuidGeneratorInterface;

class FileSystemBase64ImageUploader implements Base64ImageUploaderInterface
{
    private $projectPath;
    private $uploadsRelativePath;
    private $base64ToMimeTypeConverter;
    private $uuidGenerator;

    public function __construct(
        string $projectPath,
        string $uploadsRelativePath,
        Base64ToMimeTypeConverterInterface $base64ToMimeTypeConverter,
        UuidGeneratorInterface $uuidGenerator
    )
    {
        $this->projectPath = $projectPath;
        $this->uploadsRelativePath = $uploadsRelativePath;
        $this->base64ToMimeTypeConverter = $base64ToMimeTypeConverter;
        $this->uuidGenerator = $uuidGenerator;
    }

    public function upload(string $base64): string
    {
        $mimeType = $this->base64ToMimeTypeConverter->convert($base64);
        $imageData = $this->getImageDataFromBase64($base64);
        file_put_contents(
            $this->createImageAbsolutePath($mimeType, $imageData),
            $imageData
        );

        return $this->createImageRelativePath($mimeType, $imageData);
    }

    private function getImageDataFromBase64(string $base64): string
    {
        $base64Parts = explode(',', $base64);
        if (is_array($base64Parts) && count($base64Parts) === 2) {
            return base64_decode($base64Parts[1]);
        } else {
            throw new InvalidBase64FormatException();
        }
    }

    private function createImageRelativePath(MimeType $mimeType, string $imageData): string
    {
        return DIRECTORY_SEPARATOR
            . trim($this->uploadsRelativePath, DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR
            . $this->uuidGenerator->generate()
            . '.'
            . $mimeType->subtype();
    }

    private function createImageAbsolutePath(MimeType $mimeType, string $imageData): string
    {
        return DIRECTORY_SEPARATOR
            . trim($this->projectPath, DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR
            . trim($this->createImageRelativePath($mimeType, $imageData), DIRECTORY_SEPARATOR);
    }
}