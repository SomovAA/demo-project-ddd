<?php

namespace Application\Factory;

use Application\Entity\Order\Order;
use Application\Repository\OrderRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class OrderRepositoryFactory
{
    public static function create(ContainerInterface $container)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get('entityManager');

        return new OrderRepository($entityManager, $entityManager->getRepository(Order::class));
    }
}