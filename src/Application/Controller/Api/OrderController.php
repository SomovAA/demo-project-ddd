<?php

declare(strict_types=1);

namespace Application\Controller\Api;

use Application\Constraint\Command as Command;
use Application\Controller\AbstractController;
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
        $value = new Command\Order\Create($request->request->all());
        $violations = $validator->validate($value);

        if ($messages = $this->getViolationMessages($violations)) {
            return JsonResponseApiBuilder::create()
                ->status(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->success(false)
                ->errors($messages)
                ->build();
        }

        try {
            $order = $this->orderService->save($value->getProductIds());
        } catch (Exception $exception) {
            return JsonResponseApiBuilder::create()
                ->status(Response::HTTP_BAD_REQUEST)
                ->success(false)
                ->exception($exception)
                ->build();
        }

        return JsonResponseApiBuilder::create()
            ->status(Response::HTTP_CREATED)
            ->data(['id' => $order->getId()])
            ->build();
    }

    public function pay(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $value = new Command\Order\Pay($request->request->all());
        $violations = $validator->validate($value);

        if ($messages = $this->getViolationMessages($violations)) {
            return JsonResponseApiBuilder::create()
                ->status(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->success(false)
                ->errors($messages)
                ->build();
        }

        try {
            $this->orderService->pay($value->getPrice(), $value->getOrderId());
        } catch (Exception $exception) {
            return JsonResponseApiBuilder::create()
                ->status(Response::HTTP_BAD_REQUEST)
                ->success(false)
                ->exception($exception)
                ->build();
        }

        return JsonResponseApiBuilder::create()->build();
    }

    public function list(): JsonResponse
    {
        try {
            $orders = $this->orderService->list();
        } catch (Exception $exception) {
            return JsonResponseApiBuilder::create()
                ->status(Response::HTTP_BAD_REQUEST)
                ->success(false)
                ->exception($exception)
                ->build();
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