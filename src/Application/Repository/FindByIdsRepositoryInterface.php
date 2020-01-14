<?php

declare(strict_types=1);

namespace Application\Repository;

interface FindByIdsRepositoryInterface
{
    /**
     * @param array $ids
     *
     * @return array|object[]
     */
    public function findByIds(array $ids);
}