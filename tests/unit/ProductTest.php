<?php

use Application\Entity\Product\Product;
use Codeception\Test\Unit;

class ProductTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    public function testCreate()
    {
        $user = new Product($name = 'вилка', $price = 20.01);

        $this->assertEquals($name, $user->getName());
        $this->assertEquals($price, $user->getPrice());
    }
}