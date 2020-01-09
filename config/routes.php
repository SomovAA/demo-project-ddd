<?php

use Application\Controller\HomeController;
use Application\Controller\OrderController;
use Application\Controller\ProductController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();
$routes->add('home', new Route('/', [
    '_controller' => [HomeController::class, 'index'],
]));
$routes->add('api.v1.generate-products', new Route('/api/v1/generate-products', [
    '_controller' => [ProductController::class, 'generateProducts'],
]));
$routes->add('api.v1.order.create',
    (new Route('/api/v1/order/create'))
        ->setDefaults([
            '_controller' => [OrderController::class, 'create'],
        ])
        ->setMethods('POST')
);
$routes->add('api.v1.order.pay',
    (new Route('/api/v1/order/pay'))
        ->setDefaults([
            '_controller' => [OrderController::class, 'pay'],
        ])
        ->setMethods('POST')
);

return $routes;