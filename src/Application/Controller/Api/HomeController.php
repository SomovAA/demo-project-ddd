<?php

declare(strict_types=1);

namespace Application\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController
{
    public function index(): JsonResponse
    {
        return JsonResponse::create('API demo project ddd');
    }
}