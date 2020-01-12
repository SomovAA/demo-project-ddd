<?php

namespace Application\Controller;

use Application\Entity\Product\Product;
use Application\Service\ProductService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function generateProducts(): JsonResponse
    {
        try {
            $products = $this->productService->generateProducts();
        } catch (Exception $exception) {
            return JsonResponse::create($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        $data = [];
        /** @var Product $product */
        foreach ($products as $product) {
            $data[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
            ];
        }

        return JsonResponse::create($data);
    }
}