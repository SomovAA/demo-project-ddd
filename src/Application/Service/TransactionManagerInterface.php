<?php

declare(strict_types=1);

namespace Application\Service;

interface TransactionManagerInterface
{
    public function beginTransaction();
    public function transactional($func);
    public function commit();
    public function rollback();
}