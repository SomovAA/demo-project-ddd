<?php

use Application\Entity\Order\Order;
use Codeception\Test\Unit;

class OrderTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    public function testCreate()
    {
        $order = new Order();

        $this->assertTrue($order->isNew());
        $this->assertNotTrue($order->isPaid());
    }

    public function testMakePaid()
    {
        $order = new Order();
        $order->makePaid();

        $this->assertNotTrue($order->isNew());
        $this->assertTrue($order->isPaid());
    }
}