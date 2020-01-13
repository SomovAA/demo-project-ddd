<?php

namespace Application\Factory;

use Application\Service\FixtureService;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FixtureServiceFactory
{
    public static function create(ContainerInterface $container)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get('entityManager');
        $directory = $container->getParameter('config')['fixtures']['directory'];

        $loader = new Loader();
        $loader->loadFromDirectory($directory);
        $fixtures = $loader->getFixtures();
        $purger = new ORMPurger();
        $executor = new ORMExecutor($entityManager, $purger);

        return new FixtureService($executor, $fixtures);
    }
}