<?php

namespace Application\Entity\Order;

use Application\Entity\Product\Product;
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

    public function makeNew(): void
    {
        $this->status->makeNew();
    }

    public function makePaid(): void
    {
        $this->status->makePaid();
    }

    public function getProducts(): Collection
    {
        return $this->products;
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

        /** @var Product $product */
        foreach ($this->getProducts() as $product) {
            $price += $product->getPrice();
        }

        return $price;
    }
}