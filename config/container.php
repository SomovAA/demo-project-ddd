<?php

use Application\Application;
use Application\ArgumentResolver\OrderServiceValueResolver;
use Application\ArgumentResolver\ProductServiceValueResolver;
use Application\Controller\ErrorController;
use Application\Factory\FixtureServiceFactory;
use Application\Factory\OrderRepositoryFactory;
use Application\Factory\PaymentSystemServiceFactory;
use Application\Factory\ProductRepositoryFactory;
use Application\Service\TransactionManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\ErrorListener;
use Symfony\Component\HttpKernel\EventListener\ResponseListener;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

$container = new ContainerBuilder();
$container->setParameter('routes', include __DIR__ . '/routes.php');
$container->setParameter('config', include __DIR__ . '/config.php');
$container->setParameter('charset', 'UTF-8');
$container->register('annotationMetadataConfiguration')
    ->setFactory([Setup::class, 'createAnnotationMetadataConfiguration'])
    ->setArguments([
        $container->getParameter('config')['annotation_metadata_configuration']['paths'],
        $container->getParameter('config')['annotation_metadata_configuration']['is_dev_mode'],
        null,
        null,
        false,
    ]);
$container->register('entityManager')
    ->setFactory([EntityManager::class, 'create'])
    ->setArguments([
        $container->getParameter('config')['db'],
        new Reference('annotationMetadataConfiguration'),
    ]);
$container->register('transactionManager', TransactionManager::class)
    ->setArguments([
        new Reference('entityManager'),
    ]);
$container->register('context', RequestContext::class);
$container->register('matcher', UrlMatcher::class)
    ->setArguments([
        '%routes%',
        new Reference('context'),
    ]);
$container->register('client', Client::class)
    ->setArguments([
        ['verify' => false],
    ]);
$container->register('requestStack', RequestStack::class);
$container->register('controllerResolver', ControllerResolver::class);
$container->register('productRepository')
    ->setFactory([ProductRepositoryFactory::class, 'create'])
    ->setArguments([
        $container,
    ]);
$container->register('orderRepository')
    ->setFactory([OrderRepositoryFactory::class, 'create'])
    ->setArguments([
        $container,
    ]);
$container->register('paymentSystemService')
    ->setFactory([PaymentSystemServiceFactory::class, 'create'])
    ->setArguments([
        $container,
    ]);
$container->register('orderServiceValueResolver', OrderServiceValueResolver::class)
    ->setArguments([
        new Reference('orderRepository'),
        new Reference('productRepository'),
        new Reference('paymentSystemService'),
        new Reference('transactionManager'),
    ]);
$container->register('fixtureService')
    ->setFactory([FixtureServiceFactory::class, 'create'])
    ->setArguments([
        $container,
    ]);
$container->register('productServiceValueResolver', ProductServiceValueResolver::class)
    ->setArguments([
        new Reference('productRepository'),
        new Reference('fixtureService'),
        new Reference('transactionManager'),
    ]);
$container->register('argumentResolver', ArgumentResolver::class)
    ->setArguments([
        null,
        array_merge(
            (array)ArgumentResolver::getDefaultArgumentValueResolvers(),
            [
                new Reference('orderServiceValueResolver'),
                new Reference('productServiceValueResolver'),
            ]
        ),
    ]);
$container->register('listener.router', RouterListener::class)
    ->setArguments([
        new Reference('matcher'),
        new Reference('requestStack'),
    ]);
$container->register('listener.response', ResponseListener::class)
    ->setArguments(['%charset%']);
$container->register('listener.error', ErrorListener::class)
    ->setArguments([[ErrorController::class, 'exception']]);
$container->register('dispatcher', EventDispatcher::class)
    ->addMethodCall('addSubscriber', [new Reference('listener.router')])
    ->addMethodCall('addSubscriber', [new Reference('listener.response')])
    ->addMethodCall('addSubscriber', [new Reference('listener.error')]);
$container->register('application', Application::class)
    ->setArguments([
        new Reference('dispatcher'),
        new Reference('controllerResolver'),
        new Reference('requestStack'),
        new Reference('argumentResolver'),
    ]);

return $container;