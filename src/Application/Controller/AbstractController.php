<?php

namespace Application\Controller;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class AbstractController
{
    protected function getViolationMessages(ConstraintViolationListInterface $violations)
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
}