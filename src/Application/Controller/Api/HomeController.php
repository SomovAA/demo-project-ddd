<?php

declare(strict_types=1);

namespace Application\Controller\Api;

use Application\Service\JsonResponseApiBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function index(): JsonResponse
    {
        return JsonResponseApiBuilder::create()
            ->data(['API demo project ddd'])
            ->status(Response::HTTP_OK)
            ->build();
    }
}