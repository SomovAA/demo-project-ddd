<?php

namespace Application\Factory;

use Application\Entity\Product\Product;
use Application\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ProductRepositoryFactory
{
    public static function create(ContainerInterface $container)
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $container->get('entityManager');

        /** @var ObjectRepository|EntityRepository $repository */
        $repository = $entityManager->getRepository(Product::class);

        return new ProductRepository($entityManager, $repository);
    }
}