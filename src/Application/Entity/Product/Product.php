<?php

namespace Application\Entity\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 */
class Product
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min="1")
     */
    private $name;
    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\Type(type="float")
     * @Assert\Range(min="0")
     */
    private $price;
    /**
     * @ORM\ManyToMany(targetEntity="Application\Entity\Order\Order", mappedBy="products", cascade={"persist"})
     * @var Collection
     */
    private $orders;

    public function __construct(string $name, float $price)
    {
        $this->name = $name;
        $this->price = $price;
        $this->orders = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}