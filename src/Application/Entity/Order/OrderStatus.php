<?php

namespace Application\Entity\Order;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Embeddable
 */
class OrderStatus
{
    const NEW = 'new';
    const PAID = 'paid';

    /**
     * @ORM\Column(type="string")
     * @Assert\Choice(
     *     choices={"new", "paid"},
     *     message="Статус указан некорректно"
     * )
     */
    private $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public static function createNew()
    {
        return new static(self::NEW);
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function isNew(): bool
    {
        return static::NEW === $this->status;
    }

    public function isPaid(): bool
    {
        return static::PAID === $this->status;
    }

    public function makeNew(): void
    {
        $this->status = static::NEW;
    }

    public function makePaid(): void
    {
        $this->status = static::PAID;
    }
}