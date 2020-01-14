<?php

declare(strict_types=1);

namespace Application\Repository;

interface FindByUserIdRepositoryInterface
{
    /**
     * @param $id
     *
     * @return array|object[]
     */
    public function findByUserId($id);
}