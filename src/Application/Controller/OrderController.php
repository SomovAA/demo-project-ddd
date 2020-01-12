<?php

namespace Application\Controller;

use Application\Constraint\Command as Command;
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
        $value = new Command\Order\Create($request);
        $violations = $validator->validate($value);

        if ($messages = $this->getViolationMessages($violations)) {
            return JsonResponse::create($messages, Response::HTTP_BAD_REQUEST);
        }

        try {
            $order = $this->orderService->create($value->getProductIds());
        } catch (Exception $exception) {
            return JsonResponse::create($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return JsonResponse::create($order->getId());
    }

    public function pay(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $value = new Command\Order\Pay($request);
        $violations = $validator->validate($value);

        if ($messages = $this->getViolationMessages($violations)) {
            return JsonResponse::create($messages, Response::HTTP_BAD_REQUEST);
        }

        try {
            $this->orderService->pay($value->getPrice(), $value->getOrderId());
        } catch (Exception $exception) {
            return JsonResponse::create($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return JsonResponse::create('success');
    }
}