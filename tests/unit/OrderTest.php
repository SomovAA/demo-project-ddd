<?php

use Application\Entity\Order\Order;
use Application\Entity\Product\Product;
use Application\Entity\User\DummyUser;
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

    public function testGetPrice()
    {
        $order = new Order();
        $products = [
            new Product('test', $priceOne = 1.3),
            new Product('test2', $priceTwo = 1.7),
        ];
        $order->addProducts($products);
        $price = $priceOne + $priceTwo;
        $this->assertEquals($price, $order->getPrice());
    }

    public function testCheckPriceEqualityTrue()
    {
        $order = new Order();
        $products = [
            new Product('test', $priceOne = 1.3),
            new Product('test2', $priceTwo = 1.7),
        ];
        $order->addProducts($products);
        $price = $priceOne + $priceTwo;
        $this->assertTrue($order->checkPriceEquality($price));
    }

    public function testCheckPriceEqualityFalse()
    {
        $order = new Order();
        $products = [
            new Product('test', $priceOne = 1.3),
            new Product('test2', $priceTwo = 1.7),
        ];
        $order->addProducts($products);
        $this->assertNotTrue($order->checkPriceEquality(1));
    }

    public function testCheckAttachedUser()
    {
        $order = new Order();
        $user = new DummyUser();
        $order->attachUser($user);
        $this->assertTrue($order->checkAttachedUser($user));
    }
}