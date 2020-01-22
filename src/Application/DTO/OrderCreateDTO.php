<?php

declare(strict_types=1);

namespace Application\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class OrderCreateDTO
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="array")
     * @Assert\Count(min="1", minMessage="Должен быть хотя бы один ID товара")
     * @Assert\All({
     *     @Assert\NotBlank,
     *     @Assert\Type(type="int", message="ID товара должно быть целым числом")
     * })
     */
    private $productIds;

    public function __construct(array $data)
    {
        $this->productIds = $data['productIds'] ?? null;
    }

    public function getProductIds(): array
    {
        return $this->productIds;
    }
}