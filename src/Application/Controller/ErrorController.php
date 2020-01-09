<?php

namespace Application\Controller;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\JsonResponse;

class ErrorController
{
    public function exception(FlattenException $exception): JsonResponse
    {
        return new JsonResponse(
            [
                'message' => $exception->getMessage(),
            ],
            $exception->getStatusCode(),
            $exception->getHeaders()
        );
    }
}