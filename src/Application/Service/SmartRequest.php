<?php

declare(strict_types=1);

namespace Application\Service;

use Symfony\Component\HttpFoundation\Request;

class SmartRequest
{
    public static function createFromGlobals(): Request
    {
        $request = Request::createFromGlobals();

        if (!$contentType = $request->headers->get('Content-Type')) {
            return $request;
        }

        if (!in_array($contentType, Request::getMimeTypes('json'))) {
            return $request;
        }

        $content = json_decode($request->getContent(), true);
        $request->request->replace(is_array($content) ? $content : []);
        $request->setRequestFormat('json');

        return $request;
    }
}