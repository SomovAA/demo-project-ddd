<?php

declare(strict_types=1);

namespace Application\Controller\Api;

use Application\Controller\AbstractController;
use Application\DTO\OrderCreateDTO;
use Application\DTO\OrderPayDTO;
use Application\Service\JsonResponseApiBuilder;
use Application\Service\OrderService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrderController extends AbstractController
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $orderCreateDTO = new OrderCreateDTO($request->request->all());

        if ($jsonResponseError = $this->getJsonResponseError($validator->validate($orderCreateDTO))) {
            return $jsonResponseError;
        }

        try {
            $order = $this->orderService->create($orderCreateDTO);
        } catch (Exception $exception) {
            return $this->getJsonResponseException($exception);
        }

        return JsonResponseApiBuilder::create()
            ->status(Response::HTTP_CREATED)
            ->data(['id' => $order->getId()])
            ->build();
    }

    public function pay(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $orderPayDTO = new OrderPayDTO($request->request->all());

        if ($jsonResponseError = $this->getJsonResponseError($validator->validate($orderPayDTO))) {
            return $jsonResponseError;
        }

        try {
            $this->orderService->pay($orderPayDTO);
        } catch (Exception $exception) {
            return $this->getJsonResponseException($exception);
        }

        return JsonResponseApiBuilder::create()->build();
    }

    public function list(): JsonResponse
    {
        try {
            $orders = $this->orderService->list();
        } catch (Exception $exception) {
            return $this->getJsonResponseException($exception);
        }

        $data = [];
        foreach ($orders as $order) {
            $products = $order->getProducts();
            $productIds = [];
            foreach ($products as $product) {
                $productIds[] = $product->getId();
            }
            $data[] = [
                'id' => $order->getId(),
                'status' => $order->getStatus(),
                'price' => $order->getPrice(),
                'product_ids' => $productIds,
            ];
        }

        return JsonResponseApiBuilder::create()
            ->data($data)
            ->build();
    }
}