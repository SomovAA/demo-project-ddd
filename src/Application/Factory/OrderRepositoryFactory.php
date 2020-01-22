<?php

declare(strict_types=1);

namespace Application\Factory;

use Application\Entity\Order\Order;
use Application\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

class OrderRepositoryFactory
{
    public static function create(ContainerInterface $container)
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $container->get(EntityManagerInterface::class);

        /** @var ObjectRepository|EntityRepository $repository */
        $repository = $entityManager->getRepository(Order::class);

        return new OrderRepository($entityManager, $repository);
    }
}