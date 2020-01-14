<?php

declare(strict_types=1);

namespace Application\Service;

use Application\Entity\Product\Product;
use Application\Repository\ProductRepository;

class ProductService
{
    private $productRepository;
    private $fixtureService;
    private $transactionManager;

    public function __construct(
        ProductRepository $productRepository,
        FixtureService $fixtureService,
        TransactionManagerInterface $transactionManager
    ) {
        $this->productRepository = $productRepository;
        $this->fixtureService = $fixtureService;
        $this->transactionManager = $transactionManager;
    }

    /**
     * @return object[]|Product[]
     */
    public function generateProducts()
    {
        $this->transactionManager->transactional(function () {
            $this->fixtureService->load();
        });

        return $this->productRepository->findAll();
    }

    /**
     * @return array|Product[]
     */
    public function list(): array
    {
        return $this->productRepository->findAll();
    }
}