<?php

namespace App\Infrastructure\Common\Controller;

use App\Application\Common\Exception\ResourceNotFoundException;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

class ExceptionController
{
    public function showAction(Request $request, $exception, DebugLoggerInterface $logger = null)
    {
        if ($exception instanceof FlattenException) {
            $error = $exception->getMessage();
            $code = Response::HTTP_BAD_REQUEST;
        } else {
            $error = $exception->getMessage();
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return new JsonResponse(['message' => $error], $code);
    }
}