<?php

namespace Application\Service;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;

class FixtureService
{
    /**
     * @var ORMExecutor
     */
    private $executor;

    /**
     * @var array
     */
    private $fixtures;

    public function __construct(ORMExecutor $executor, array $fixtures)
    {
        $this->executor = $executor;
        $this->fixtures = $fixtures;
    }

    public function load(): void
    {
        $this->executor->execute($this->fixtures);
    }
}