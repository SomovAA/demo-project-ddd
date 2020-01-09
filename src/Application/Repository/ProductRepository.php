<?php

namespace Application\Repository;

use Application\Entity\Product\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class ProductRepository
{
    private $entityManager;

    private $entityRepository;

    public function __construct(EntityManager $entityManager, EntityRepository $entityRepository)
    {
        $this->entityManager = $entityManager;
        $this->entityRepository = $entityRepository;
    }

    /**
     * @return Product[]|array
     */
    public function findAll(): array
    {
        return $this->entityRepository->findAll();
    }

    /**
     * @param array $ids
     *
     * @return Product[]
     */
    public function findByIds(array $ids): array
    {
        return $this->entityRepository->findBy(['id' => $ids]);
    }
}