<?php

declare(strict_types=1);

use Application\Controller\Api\HomeController as ApiHomeController;
use Application\Controller\Api\OrderController;
use Application\Controller\Api\ProductController;
use Application\Controller\HomeController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();
$routes->add('home', new Route('/', [
    '_controller' => [HomeController::class, 'index'],
]));
$routes->add('api.v1.home', new Route('/api', [
    '_controller' => [ApiHomeController::class, 'index'],
]));
$routes->add('api.v1.products.generate',
    (new Route('/api/v1/products/generate'))
        ->setDefaults([
            '_controller' => [$container->get(ProductController::class), 'generateProducts'],
        ])
        ->setMethods('POST')
);
$routes->add('api.v1.products.list',
    (new Route('/api/v1/products'))
        ->setDefaults([
            '_controller' => [$container->get(ProductController::class), 'list'],
        ])
        ->setMethods('GET')
);
$routes->add('api.v1.orders.create',
    (new Route('/api/v1/orders'))
        ->setDefaults([
            '_controller' => [$container->get(OrderController::class), 'create'],
        ])
        ->setMethods('POST')
);
$routes->add('api.v1.orders.list',
    (new Route('/api/v1/orders'))
        ->setDefaults([
            '_controller' => [$container->get(OrderController::class), 'list'],
        ])
        ->setMethods('GET')
);
$routes->add('api.v1.orders.pay',
    (new Route('/api/v1/orders/pay'))
        ->setDefaults([
            '_controller' => [$container->get(OrderController::class), 'pay'],
        ])
        ->setMethods('POST')
);

return $routes;