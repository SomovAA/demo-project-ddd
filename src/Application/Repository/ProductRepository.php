<?php

declare(strict_types=1);

namespace Application\Repository;

use Application\Entity\Product\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;

class ProductRepository implements ObjectRepository, FindByIdsRepositoryInterface
{
    private $entityManager;
    private $entityRepository;

    public function __construct(EntityManagerInterface $entityManager, EntityRepository $entityRepository)
    {
        $this->entityManager = $entityManager;
        $this->entityRepository = $entityRepository;
    }

    /**
     * @param $id
     *
     * @return object|null|Product
     */
    public function find($id)
    {
        return $this->entityRepository->find($id);
    }

    /**
     * @return array|object[]|Product[]
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
     * @return array|object[]|Product[]
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->entityRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param array $criteria
     *
     * @return object|null|Product
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
     * @param array $ids
     *
     * @return Product[]|array|object[]
     */
    public function findByIds(array $ids)
    {
        return $this->findBy(['id' => $ids]);
    }
}