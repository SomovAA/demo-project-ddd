<?php

declare(strict_types=1);

namespace Application\Entity\User;

class DummyUser extends User
{
    public function __construct()
    {
        parent::__construct('admin');
        $this->id = 1;
    }
}