<?php

namespace Application\Constraint\Command\Order;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class Create
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="array")
     * @Assert\Count(min="1", minMessage="Должен быть хотя бы один ID товара")
     * @Assert\All({
     *     @Assert\NotBlank,
     *     @Assert\Regex(
     *          pattern="/^[0-9]+$/",
     *          message="ID товара должно быть целым числом"
     *     )
     * })
     */
    private $productIds;

    public function __construct(Request $request)
    {
        $this->productIds = $request->request->get('productIds', []);
    }

    public function getProductIds(): array
    {
        return $this->productIds;
    }
}