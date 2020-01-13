<?php

namespace Application\ArgumentResolver;

use Application\Repository\ProductRepository;
use Application\Service\FixtureService;
use Application\Service\ProductService;
use Application\Service\TransactionManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class ProductServiceValueResolver implements ArgumentValueResolverInterface
{
    private $productRepository;
    private $fixtureService;
    private $transactionManager;

    public function __construct(
        ProductRepository $productRepository,
        FixtureService $fixtureService,
        TransactionManager $transactionManager
    ) {
        $this->productRepository = $productRepository;
        $this->fixtureService = $fixtureService;
        $this->transactionManager = $transactionManager;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return ProductService::class === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        yield new ProductService($this->productRepository, $this->fixtureService, $this->transactionManager);
    }
}