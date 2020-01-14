<?php

declare(strict_types=1);

namespace Application\Controller;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ErrorController
{
    public function exception(FlattenException $exception, Request $request): Response
    {
        if ($request->getRequestFormat() === 'json') {
            return new JsonResponse(
                [
                    'exception' => $exception->getMessage(),
                ],
                $exception->getStatusCode(),
                $exception->getHeaders()
            );
        }

        return new Response($exception->getMessage(), $exception->getStatusCode(), $exception->getHeaders());
    }
}