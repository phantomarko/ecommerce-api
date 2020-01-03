<?php

namespace App\Domain\Common\Service;

interface Base64ToMimeTypeConverterInterface
{
    public function convert(string $base64): MimeType;
}