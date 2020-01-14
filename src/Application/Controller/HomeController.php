<?php

declare(strict_types=1);

namespace Application\Controller;

use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function index(): Response
    {
        return new Response('Hello');
    }
}