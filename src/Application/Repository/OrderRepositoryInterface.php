<?php

namespace Application\Repository;

use Doctrine\Persistence\ObjectRepository;

interface OrderRepositoryInterface extends ObjectRepository, CUDRepositoryInterface
{
}