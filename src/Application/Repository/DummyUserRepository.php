<?php

declare(strict_types=1);

namespace Application\Repository;

use Application\Entity\User\DummyUser;

class DummyUserRepository implements UserRepositoryInterface
{
    /**
     * @return object|null|DummyUser
     */
    public function get()
    {
        return new DummyUser();
    }
}