<?php

declare(strict_types=1);

namespace Application\Controller\Api;

use Application\Controller\AbstractController;
use Application\Service\JsonResponseApiBuilder;
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
            return JsonResponseApiBuilder::create()
                ->status(Response::HTTP_BAD_REQUEST)
                ->success(false)
                ->exception($exception)
                ->build();
        }

        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
            ];
        }

        return JsonResponseApiBuilder::create()
            ->data($data)
            ->status(Response::HTTP_CREATED)
            ->build();
    }

    public function list()
    {
        try {
            $products = $this->productService->list();
        } catch (Exception $exception) {
            return JsonResponseApiBuilder::create()
                ->status(Response::HTTP_BAD_REQUEST)
                ->success(false)
                ->exception($exception)
                ->build();
        }

        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
            ];
        }

        return JsonResponseApiBuilder::create()
            ->data($data)
            ->build();
    }
}