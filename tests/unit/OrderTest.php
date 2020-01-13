<?php

use Application\Entity\Order\Order;
use Application\Exception\Order\OrderIsAlreadyNewException;
use Application\Exception\Order\OrderIsAlreadyPaidException;
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

    public function testMakePaidForPaidOrder()
    {
        $order = new Order();
        $order->makePaid();
        $this->expectException(OrderIsAlreadyPaidException::class);
        $order->makePaid();
    }

    public function testMakeNewForNewOrder()
    {
        $order = new Order();
        $this->expectException(OrderIsAlreadyNewException::class);
        $order->makeNew();
    }
}