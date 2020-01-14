<?php

use Application\Entity\User\DummyUser;
use Application\Entity\User\User;
use Codeception\Test\Unit;

class UserTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    public function testCreate()
    {
        $user = new User($login = 'test');

        $this->assertEquals($login, $user->getLogin());
    }

    public function testCreateDummy()
    {
        $user = new DummyUser();

        $this->assertEquals('admin', $user->getLogin());
        $this->assertEquals(1, $user->getId());
    }
}