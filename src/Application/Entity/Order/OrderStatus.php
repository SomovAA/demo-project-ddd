<?php

namespace Application\Entity\Order;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class OrderStatus
{
    const NEW = 'new';
    const PAID = 'paid';

    /**
     * @ORM\Column(type="string")
     */
    private $status;

    public function __construct(string $status = self::NEW)
    {
        $this->status = $status;
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