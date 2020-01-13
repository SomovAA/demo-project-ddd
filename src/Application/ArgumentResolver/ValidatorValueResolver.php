<?php

namespace Application\ArgumentResolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorValueResolver implements ArgumentValueResolverInterface
{
    private $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return ValidatorInterface::class === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        yield Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->setTranslator($this->translator)
            ->getValidator();
    }
}