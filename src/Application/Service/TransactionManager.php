<?php

namespace Application\Service;

use Doctrine\ORM\EntityManager;
use Throwable;

class TransactionManager implements TransactionManagerInterface
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function beginTransaction()
    {
        $this->entityManager->beginTransaction();
    }

    /**
     * @param $func
     *
     * @throws Throwable
     */
    public function transactional($func)
    {
        $this->entityManager->transactional($func);
    }

    public function commit()
    {
        $this->entityManager->commit();
    }

    public function rollback()
    {
        $this->entityManager->rollback();
    }
}