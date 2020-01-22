<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Service\JsonResponseApiBuilder;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class AbstractController
{
    protected function getViolationMessages(ConstraintViolationListInterface $violations): array
    {
        if (!$violations->count()) {
            return [];
        }

        $messages = [];
        /** @var ConstraintViolation $violation */
        foreach ($violations as $violation) {
            $messages[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        return $messages;
    }

    protected function getJsonResponseError(ConstraintViolationListInterface $violations): ?JsonResponse
    {
        if ($messages = $this->getViolationMessages($violations)) {
            return JsonResponseApiBuilder::create()
                ->status(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->success(false)
                ->errors($messages)
                ->build();
        }

        return null;
    }

    protected function getJsonResponseException(Exception $exception)
    {
        return JsonResponseApiBuilder::create()
            ->status(Response::HTTP_BAD_REQUEST)
            ->success(false)
            ->exception($exception)
            ->build();
    }
}