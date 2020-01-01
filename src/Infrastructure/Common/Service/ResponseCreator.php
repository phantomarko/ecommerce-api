<?php

namespace App\Infrastructure\Common\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseCreator
{
    public function create(?array $data, ?string $message, ?int $code)
    {
        $responseCode = $code ?? Response::HTTP_OK;
        return new JsonResponse(
            [
                'data' => $data,
                'message' => $message,
                'code' => $responseCode
            ],
            $responseCode
        );
    }
}