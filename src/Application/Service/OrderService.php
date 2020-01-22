<?php

declare(strict_types=1);

namespace Application\Service;

use Application\DTO\OrderCreateDTO;
use Application\DTO\OrderPayDTO;
use Application\Entity\Order\Order;
use Application\Entity\User\User;
use Application\Exception\Order\OrderIsAlreadyPaidException;
use Application\Exception\Order\OrderNotFoundException;
use Application\Exception\Order\OrderNotNewException;
use Application\Exception\Order\OrderPaymentFailedException;
use Application\Exception\Order\OrderPriceDoesNotMatchException;
use Application\Exception\Order\OrderSuchProductsDoNotExistException;
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
     * @param OrderCreateDTO $dto
     *
     * @return Order
     * @throws OrderSuchProductsDoNotExistException
     * @throws OrderWithoutProductCannotBeCreatedException
     */
    public function create(OrderCreateDTO $dto): Order
    {
        $products = $this->productRepository->findByIds($dto->getProductIds());

        if (!$products) {
            throw new OrderWithoutProductCannotBeCreatedException();
        }

        $order = new Order();
        $order->addProducts($products);

        if ($diffIds = $order->getDiffProductIds($dto->getProductIds())) {
            throw new OrderSuchProductsDoNotExistException(
                sprintf('Such products %s do not exist. Order cannot be created', implode(', ', $diffIds))
            );
        }

        /** @var User $user */
        $user = $this->userRepository->get();
        $order->attachUser($user);

        $this->transactionManager->transactional(function () use ($order) {
            $this->orderRepository->create($order);
        });

        return $order;
    }

    /**
     * @param OrderPayDTO $dto
     *
     * @return object|Order
     * @throws OrderIsAlreadyPaidException
     * @throws OrderNotFoundException
     * @throws OrderNotNewException
     * @throws OrderPaymentFailedException
     * @throws OrderPriceDoesNotMatchException
     */
    public function pay(OrderPayDTO $dto): Order
    {
        $order = $this->orderRepository->find($dto->getOrderId());

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

        if (!$order->checkPriceEquality($dto->getPrice())) {
            throw new OrderPriceDoesNotMatchException();
        }

        $this->paymentSystemService->pay();

        $order->makePaid();

        $this->transactionManager->transactional(function () use ($order) {
            $this->orderRepository->update($order);
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