<?php

namespace App\Infrastructure\Common\Service;

use App\Domain\Common\Exception\InvalidBase64FormatException;
use App\Domain\Common\Service\Base64ToMimeTypeConverterInterface;
use App\Domain\Common\Service\MimeType;

class FileSystemBase64ToMimeTypeConverter implements Base64ToMimeTypeConverterInterface
{
    public function convert(string $base64): MimeType
    {
        $mimeType = null;
        $base64Parts = explode(',', $base64);
        if (is_array($base64Parts) && count($base64Parts) === 2) {
            $infoPart = explode(';', $base64Parts[0]);
            if (is_array($infoPart) && count($infoPart) === 2) {
                $mimeTypePart = explode(':', $infoPart[0]);
                if (is_array($mimeTypePart) && count($mimeTypePart) === 2) {
                    $mimeTypesParameters = explode('/', $mimeTypePart[1]);
                    if (is_array($mimeTypesParameters) && count($mimeTypesParameters) === 2) {
                        $mimeType = new MimeType($mimeTypesParameters[0], $mimeTypesParameters[1]);
                    }
                }
            }
        }

        if (empty($mimeType)) {
            throw new InvalidBase64FormatException();
        } else {
            return $mimeType;
        }
    }

}