<?php

namespace Application\ArgumentResolver;

use Application\Repository\OrderRepository;
use Application\Repository\ProductRepository;
use Application\Service\OrderService;
use Application\Service\PaymentSystemService;
use Application\Service\TransactionManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class OrderServiceValueResolver implements ArgumentValueResolverInterface
{
    private $orderRepository;
    private $productRepository;
    private $paymentSystemService;
    private $transactionManager;

    public function __construct(
        OrderRepository $orderRepository,
        ProductRepository $productRepository,
        PaymentSystemService $paymentSystemService,
        TransactionManager $transactionManager
    ) {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->paymentSystemService = $paymentSystemService;
        $this->transactionManager = $transactionManager;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return OrderService::class === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        yield new OrderService(
            $this->orderRepository,
            $this->productRepository,
            $this->paymentSystemService,
            $this->transactionManager
        );
    }
}