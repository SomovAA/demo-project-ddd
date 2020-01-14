<?php

declare(strict_types=1);

namespace Application\Repository;

interface UserRepositoryInterface
{
    /**
     * @return object|null
     */
    public function get();
}