<?php

namespace Application\Service;

interface TransactionManagerInterface
{
    public function beginTransaction();
    public function transactional($func);
    public function commit();
    public function rollback();
}