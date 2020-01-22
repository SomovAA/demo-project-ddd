<?php

declare(strict_types=1);

namespace Application\Repository;

use Application\Entity\Order\Order;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;

class OrderRepository implements ObjectRepository, CUDRepositoryInterface, FindByUserIdRepositoryInterface
{
    private $entityManager;
    private $entityRepository;

    public function __construct(EntityManagerInterface $entityManager, EntityRepository $entityRepository)
    {
        $this->entityManager = $entityManager;
        $this->entityRepository = $entityRepository;
    }

    /**
     * @param Order $object
     *
     * @return void
     */
    public function create($object)
    {
        $this->save($object);
    }

    /**
     * @param Order $object
     *
     * @return void
     */
    public function update($object)
    {
        $this->save($object);
    }

    /**
     * @param Order $object
     *
     * @return void
     */
    public function delete($object)
    {
        $this->entityManager->remove($object);
        $this->entityManager->flush();
    }

    /**
     * @param $id
     *
     * @return object|null|Order
     */
    public function find($id)
    {
        return $this->entityRepository->find($id);
    }

    /**
     * @return array|object[]|Order[]
     */
    public function findAll()
    {
        return $this->entityRepository->findAll();
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     *
     * @return array|object[]|Order[]
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->entityRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param array $criteria
     *
     * @return object|null|Order
     */
    public function findOneBy(array $criteria)
    {
        return $this->entityRepository->findOneBy($criteria);
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->entityRepository->getClassName();
    }

    /**
     * @param $id
     *
     * @return Order[]|array|object[]
     */
    public function findByUserId($id)
    {
        return $this->findBy(['userId' => $id]);
    }

    /**
     * @param Order $object
     *
     * @return void
     */
    private function save($object)
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();
    }
}