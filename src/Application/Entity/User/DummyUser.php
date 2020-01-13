<?php

namespace Application\Entity\User;

class DummyUser
{
    private $id = 1;
    private $login = 'admin';

    public function getId(): int
    {
        return $this->id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }
}