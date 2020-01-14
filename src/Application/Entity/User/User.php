<?php

declare(strict_types=1);

namespace Application\Entity\User;

class User
{
    protected $id;
    protected $login;

    public function __construct(string $login)
    {
        $this->login = $login;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }
}