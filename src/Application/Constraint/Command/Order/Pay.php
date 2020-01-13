<?php

namespace Application\Constraint\Command\Order;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class Pay
{
    /**
     * @Assert\NotBlank()
     * @Assert\Regex(
     *      pattern="/^[0-9]+$/",
     *      message="ID заказа должно быть целым числом"
     * )
     */
    private $orderId;
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="numeric")
     */
    private $price;

    public function __construct(Request $request)
    {
        $this->price = $request->request->get('price', 0.0);
        $this->orderId = $request->request->get('orderId', 0);
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}