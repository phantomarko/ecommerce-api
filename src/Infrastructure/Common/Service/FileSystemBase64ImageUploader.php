<?php

namespace App\Infrastructure\Common\Service;

use App\Domain\Common\Exception\InvalidBase64FormatException;
use App\Domain\Common\Service\Base64ImageUploaderInterface;
use App\Domain\Common\Service\Base64ToMimeTypeConverterInterface;
use App\Domain\Common\Service\MimeType;
use App\Domain\Common\Service\UuidGeneratorInterface;

class FileSystemBase64ImageUploader implements Base64ImageUploaderInterface
{
    private $uploadDirectory;
    private $base64ToMimeTypeConverter;
    private $uuidGenerator;

    public function __construct(
        string $uploadDirectory,
        Base64ToMimeTypeConverterInterface $base64ToMimeTypeConverter,
        UuidGeneratorInterface $uuidGenerator
    )
    {
        $this->uploadDirectory = $uploadDirectory;
        $this->base64ToMimeTypeConverter = $base64ToMimeTypeConverter;
        $this->uuidGenerator = $uuidGenerator;
    }

    public function upload(string $base64): \SplFileInfo
    {
        $mimeType = $this->base64ToMimeTypeConverter->convert($base64);
        $imageData = $this->getImageDataFromBase64($base64);
        $imagePath = $this->createImageUploadedPath($mimeType, $imageData);
        file_put_contents($imagePath, $imageData);

        return new \SplFileInfo($imagePath);
    }

    private function getImageDataFromBase64(string $base64): string
    {
        $base64Parts = explode(',', $base64);
        if (is_array($base64Parts) && count($base64Parts) === 2) {
            return $base64Parts[1];
        } else {
            throw new InvalidBase64FormatException();
        }
    }

    private function createImageUploadedPath(MimeType $mimeType, string $imageData): string
    {
        return $this->uploadDirectory
            . DIRECTORY_SEPARATOR
            . $this->uuidGenerator->generate()
            . '.'
            . $mimeType->subtype();
    }
}