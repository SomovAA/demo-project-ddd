<?php

declare(strict_types=1);

namespace Application\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class OrderPayDTO
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="int", message="ID заказа должно быть целым числом")
     */
    private $orderId;
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="numeric")
     */
    private $price;

    public function __construct(array $data)
    {
        $this->price = $data['price'] ?? null;
        $this->orderId = $data['orderId'] ?? null;
    }

    /**
     * @return int|mixed|null
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @return float|mixed|null
     */
    public function getPrice()
    {
        return $this->price;
    }
}