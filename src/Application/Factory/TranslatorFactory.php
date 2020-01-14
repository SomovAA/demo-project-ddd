<?php

declare(strict_types=1);

namespace Application\Factory;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\Translation\Translator;

class TranslatorFactory
{
    public static function create(ContainerInterface $container)
    {
        /** @var array $config */
        $config = $container->getParameter('config');

        $translator = new Translator('ru');
        $translator->addLoader('xlf', new XliffFileLoader());
        $translator->addResource('xlf', $config['translator']['resource'], 'ru');

        return $translator;
    }
}