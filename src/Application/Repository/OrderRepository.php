<?php

namespace Application\Repository;

use Application\Entity\Order\Order;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class OrderRepository
{
    private $entityManager;
    private $entityRepository;

    public function __construct(EntityManager $entityManager, EntityRepository $entityRepository)
    {
        $this->entityManager = $entityManager;
        $this->entityRepository = $entityRepository;
    }

    /**
     * @param int $id
     *
     * @return object|null|Order
     */
    public function find(int $id): ?Order
    {
        return $this->entityRepository->find($id);
    }

    /**
     * @param Order $order
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(Order $order): void
    {
        $this->entityManager->persist($order);
        $this->entityManager->flush($order);
    }

    /**
     * @param Order $order
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Order $order): void
    {
        $this->entityManager->flush($order);
    }
}