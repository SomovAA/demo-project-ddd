<?php

namespace Application\Service;

use Application\Repository\ProductRepositoryInterface;

class ProductService
{
    private $productRepository;
    private $fixtureService;
    private $transactionManager;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        FixtureService $fixtureService,
        TransactionManagerInterface $transactionManager
    ) {
        $this->productRepository = $productRepository;
        $this->fixtureService = $fixtureService;
        $this->transactionManager = $transactionManager;
    }

    public function generateProducts()
    {
        $this->transactionManager->transactional(function () {
            $this->fixtureService->load();
        });

        return $this->productRepository->findAll();
    }
}