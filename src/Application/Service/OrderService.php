<?php

declare(strict_types=1);

namespace Application\Service;

use Application\Entity\Order\Order;
use Application\Entity\User\User;
use Application\Exception\Order\OrderIsAlreadyPaidException;
use Application\Exception\Order\OrderNotFoundException;
use Application\Exception\Order\OrderNotNewException;
use Application\Exception\Order\OrderPaymentFailedException;
use Application\Exception\Order\OrderPriceDoesNotMatchException;
use Application\Exception\Order\OrderWithoutProductCannotBeCreatedException;
use Application\Repository\OrderRepository;
use Application\Repository\ProductRepository;
use Application\Repository\UserRepositoryInterface;

class OrderService
{
    private $orderRepository;
    private $productRepository;
    private $paymentSystemService;
    private $transactionManager;
    private $userRepository;

    public function __construct(
        OrderRepository $orderRepository,
        ProductRepository $productRepository,
        PaymentSystemService $paymentSystemService,
        TransactionManagerInterface $transactionManager,
        UserRepositoryInterface $userRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->paymentSystemService = $paymentSystemService;
        $this->transactionManager = $transactionManager;
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $productIds
     *
     * @return Order
     * @throws OrderWithoutProductCannotBeCreatedException
     */
    public function create(array $productIds): Order
    {
        $products = $this->productRepository->findByIds($productIds);

        if (!$products) {
            throw new OrderWithoutProductCannotBeCreatedException();
        }

        $order = new Order();
        $order->addProducts($products);

        /** @var User $user */
        $user = $this->userRepository->get();
        $order->attachUser($user);

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
     * @throws OrderIsAlreadyPaidException
     */
    public function pay(float $price, int $id): Order
    {
        $order = $this->orderRepository->find($id);

        if (!$order) {
            throw new OrderNotFoundException();
        }

        /** @var User $user */
        $user = $this->userRepository->get();

        if (!$order->checkAttachedUser($user)) {
            throw new OrderNotFoundException();
        }

        if (!$order->isNew()) {
            throw new OrderNotNewException();
        }

        if (!$order->checkPriceEquality($price)) {
            throw new OrderPriceDoesNotMatchException();
        }

        $this->paymentSystemService->pay();

        $order->makePaid();

        $this->transactionManager->transactional(function () use ($order) {
            $this->orderRepository->create($order);
        });

        return $order;
    }

    /**
     * @return array|Order[]
     */
    public function list(): array
    {
        /** @var User $user */
        $user = $this->userRepository->get();

        return $this->orderRepository->findByUserId($user->getId());
    }
}