<?php

namespace App\Domain\Common\Service;

interface Base64ImageUploaderInterface
{
    public function upload(string $base64): string;
}