<?php

namespace Application\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController
{
    public function index(): JsonResponse
    {
        return JsonResponse::create('Hello');
    }
}