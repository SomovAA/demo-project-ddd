<?php

declare(strict_types=1);

namespace Application\Service;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonResponseApiBuilder
{
    private $body = [];
    private $status;
    private $headers = [];

    /**
     * @return static
     */
    public static function create()
    {
        $object = new static();
        $object->status(Response::HTTP_OK);
        $object->success(true);

        return $object;
    }

    public function success(bool $success)
    {
        $this->body['success'] = $success;

        return $this;
    }

    public function errors(array $errors)
    {
        $this->body['errors'] = $errors;

        return $this;
    }

    public function data(array $data)
    {
        $this->body['data'] = $data;

        return $this;
    }

    public function exception(Exception $exception)
    {
        $this->body['exception'] = $exception->getMessage();

        return $this;
    }

    public function status(int $status)
    {
        $this->status = $status;
        $this->body['status'] = $status;

        return $this;
    }

    public function headers(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @return JsonResponse
     */
    public function build()
    {
        return JsonResponse::create($this->body, $this->status, $this->headers);
    }
}