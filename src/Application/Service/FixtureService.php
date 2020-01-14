<?php

declare(strict_types=1);

namespace Application\Service;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;

class FixtureService
{
    private $executor;
    private $fixtures;

    public function __construct(ORMExecutor $executor, array $fixtures)
    {
        $this->executor = $executor;
        $this->fixtures = $fixtures;
    }

    public function load(): void
    {
        $this->executor->execute($this->fixtures, true);
    }
}