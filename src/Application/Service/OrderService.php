<?php

namespace Application\Service;

use Application\Entity\Order\Order;
use Application\Exception\Order\OrderNotFoundException;
use Application\Exception\Order\OrderNotNewException;
use Application\Exception\Order\OrderPaymentFailedException;
use Application\Exception\Order\OrderPriceDoesNotMatchException;
use Application\Exception\Order\OrderWithoutProductCannotBeCreatedException;
use Application\Repository\OrderRepositoryInterface;
use Application\Repository\ProductRepositoryInterface;

class OrderService
{
    private $orderRepository;
    private $productRepository;
    private $paymentSystemService;
    private $transactionManager;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ProductRepositoryInterface $productRepository,
        PaymentSystemService $paymentSystemService,
        TransactionManagerInterface $transactionManager
    ) {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->paymentSystemService = $paymentSystemService;
        $this->transactionManager = $transactionManager;
    }

    /**
     * @param array $productIds
     *
     * @return Order
     * @throws OrderWithoutProductCannotBeCreatedException
     */
    public function create(array $productIds): Order
    {
        $products = $this->productRepository->findBy(['id' => $productIds]);

        if (!$products) {
            throw new OrderWithoutProductCannotBeCreatedException();
        }

        $order = new Order();
        $order->addProducts($products);

        $this->transactionManager->transactional(function () use ($order) {
            $this->orderRepository->create($order);
        });

        return $order;
    }

    /**
     * @param float $price
     * @param int $id
     *
     * @return object|Order
     * @throws OrderNotFoundException
     * @throws OrderNotNewException
     * @throws OrderPaymentFailedException
     * @throws OrderPriceDoesNotMatchException
     */
    public function pay(float $price, int $id): Order
    {
        $order = $this->orderRepository->find($id);

        if (!$order) {
            throw new OrderNotFoundException();
        }

        if (!$order->isNew()) {
            throw new OrderNotNewException();
        }

        if (!$this->checkPriceEquality($price, $order->getPrice())) {
            throw new OrderPriceDoesNotMatchException();
        }

        $this->paymentSystemService->pay();

        $order->makePaid();

        $this->transactionManager->transactional(function () use ($order) {
            $this->orderRepository->create($order);
        });

        return $order;
    }

    private function checkPriceEquality(float $price, float $currentPrice): bool
    {
        return $price === $currentPrice;
    }
}