<?php

declare(strict_types=1);

namespace Application\Entity\Order;

use Application\Entity\Product\Product;
use Application\Entity\User\User;
use Application\Exception\Order\OrderIsAlreadyNewException;
use Application\Exception\Order\OrderIsAlreadyPaidException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 */
class Order
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var OrderStatus
     * @ORM\Embedded(class="OrderStatus", columnPrefix=false)
     */
    private $status;
    /**
     * @ORM\ManyToMany(targetEntity="Application\Entity\Product\Product", inversedBy="orders", cascade={"persist"})
     * @ORM\JoinTable(name="order_product",
     *   joinColumns={
     *     @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *   }
     * )
     * @var Collection
     */
    private $products;

    /**
     * @ORM\Column(type="integer", name="user_id")
     */
    private $userId;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->status = OrderStatus::createNew();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function isNew(): bool
    {
        return $this->status->isNew();
    }

    public function isPaid(): bool
    {
        return $this->status->isPaid();
    }

    /**
     * @throws OrderIsAlreadyNewException
     */
    public function makeNew(): void
    {
        if ($this->isNew()) {
            throw new OrderIsAlreadyNewException();
        }
        $this->status->makeNew();
    }

    /**
     * @throws OrderIsAlreadyPaidException
     */
    public function makePaid(): void
    {
        if ($this->isPaid()) {
            throw new OrderIsAlreadyPaidException();
        }
        $this->status->makePaid();
    }

    public function getStatus(): string
    {
        return $this->status->getStatus();
    }

    /**
     * @return Product[]|array
     */
    public function getProducts(): array
    {
        return $this->products->toArray();
    }

    public function addProducts(array $products): void
    {
        /** @var Product $product */
        foreach ($products as $product) {
            $this->products->add($product);
        }
    }

    public function getPrice(): float
    {
        $price = 0.0;
        foreach ($this->getProducts() as $product) {
            $price += $product->getPrice();
        }

        return $price;
    }

    public function checkPriceEquality(float $price): bool
    {
        return $price === $this->getPrice();
    }

    public function checkAttachedUser(User $user): bool
    {
        return $user->getId() === $this->userId;
    }

    public function attachUser(User $user): void
    {
        $this->userId = $user->getId();
    }
}