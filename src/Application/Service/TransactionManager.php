<?php

namespace Application\Service;

use Doctrine\ORM\EntityManagerInterface;

class TransactionManager implements TransactionManagerInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function beginTransaction()
    {
        $this->entityManager->beginTransaction();
    }

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