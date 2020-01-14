<?php

declare(strict_types=1);

namespace Application\Factory;

use Application\Service\FixtureService;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FixtureServiceFactory
{
    public static function create(ContainerInterface $container)
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $container->get('entityManager');

        /** @var array $config */
        $config = $container->getParameter('config');

        /** @var string $directory */
        $directory = $config['fixtures']['directory'];

        $loader = new Loader();
        $loader->loadFromDirectory($directory);
        $fixtures = $loader->getFixtures();
        $purger = new ORMPurger();
        $executor = new ORMExecutor($entityManager, $purger);

        return new FixtureService($executor, $fixtures);
    }
}