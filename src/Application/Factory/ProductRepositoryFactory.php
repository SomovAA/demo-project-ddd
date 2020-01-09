<?php

namespace Application\Factory;

use Application\Entity\Product\Product;
use Application\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ProductRepositoryFactory
{
    public static function create(ContainerInterface $container)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get('entityManager');

        return new ProductRepository($entityManager, $entityManager->getRepository(Product::class));
    }
}