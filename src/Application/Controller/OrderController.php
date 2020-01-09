<?php

namespace Application\Controller;

use Application\Service\OrderService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController
{
    public function create(Request $request, OrderService $orderService): JsonResponse
    {
        $productIds = (array)$request->request->get('productIds', []);

        try {
            $order = $orderService->create($productIds);
        } catch (Exception $exception) {
            return JsonResponse::create($exception->getMessage(), Response::HTTP_CONFLICT);
        }

        return JsonResponse::create($order->getId());
    }

    public function pay(Request $request, OrderService $orderService): JsonResponse
    {
        $price = (float)$request->request->get('price', 0.0);
        $id = (int)$request->request->get('orderId', 0);

        try {
            $orderService->pay($price, $id);
        } catch (Exception $exception) {
            return JsonResponse::create($exception->getMessage(), Response::HTTP_CONFLICT);
        }

        return JsonResponse::create('success');
    }
}