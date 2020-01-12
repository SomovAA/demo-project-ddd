<?php

use Application\Controller\HomeController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();
$routes->add('home', new Route('/', [
    '_controller' => [HomeController::class, 'index'],
]));
$routes->add('api.v1.generate-products', new Route('/api/v1/generate-products', [
    '_controller' => [$container->get('productController'), 'generateProducts'],
]));
$routes->add('api.v1.order.create',
    (new Route('/api/v1/order/create'))
        ->setDefaults([
            '_controller' => [$container->get('orderController'), 'create'],
        ])
        ->setMethods('POST')
);
$routes->add('api.v1.order.pay',
    (new Route('/api/v1/order/pay'))
        ->setDefaults([
            '_controller' => [$container->get('orderController'), 'pay'],
        ])
        ->setMethods('POST')
);

return $routes;