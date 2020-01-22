<?php

declare(strict_types=1);

use Application\Application;
use Application\ArgumentResolver\OrderServiceValueResolver;
use Application\ArgumentResolver\ProductServiceValueResolver;
use Application\ArgumentResolver\ValidatorValueResolver;
use Application\Controller\Api\OrderController;
use Application\Controller\Api\ProductController;
use Application\Controller\ErrorController;
use Application\Factory\FixtureServiceFactory;
use Application\Factory\OrderRepositoryFactory;
use Application\Factory\ProductRepositoryFactory;
use Application\Factory\TranslatorFactory;
use Application\Repository\DummyUserRepository;
use Application\Repository\OrderRepository;
use Application\Repository\ProductRepository;
use Application\Repository\UserRepositoryInterface;
use Application\Service\FixtureService;
use Application\Service\OrderService;
use Application\Service\PaymentSystemService;
use Application\Service\ProductService;
use Application\Service\TransactionManager;
use Application\Service\TransactionManagerInterface;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use GuzzleHttp\Client;
use Symfony\Bridge\ProxyManager\LazyProxy\Instantiator\RuntimeInstantiator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\EventListener\ErrorListener;
use Symfony\Component\HttpKernel\EventListener\ResponseListener;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Translation\Translator;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

$container = new ContainerBuilder();
$container->setProxyInstantiator(new RuntimeInstantiator());
// params
$container->setParameter('config', include __DIR__ . '/config.php');
$container->setParameter('config.db', $container->getParameter('config')['db']);
$container->setParameter('charset', 'UTF-8');
// service
$container->autowire(Configuration::class)
    ->setFactory([Setup::class, 'createAnnotationMetadataConfiguration'])
    ->setPublic(true)
    ->setArguments([
        $container->getParameter('config')['annotation_metadata_configuration']['paths'],
        $container->getParameter('config')['annotation_metadata_configuration']['is_dev_mode'],
        null,
        null,
        false,
    ]);
$container->autowire(EntityManagerInterface::class)
    ->setFactory([EntityManager::class, 'create'])
    ->setPublic(true)
    ->setArguments([
        '%config.db%',
        new Reference(Configuration::class),
    ]);
$container->autowire(TransactionManagerInterface::class, TransactionManager::class);
$container->autowire(Client::class)
    ->setPublic(true)
    ->setArguments([
        ['verify' => false],
    ]);
$container->autowire(Translator::class)
    ->setFactory([TranslatorFactory::class, 'create'])
    ->setArguments([
        '%config%',
    ]);
$container->autowire(PaymentSystemService::class)
    ->setPublic(true)
    ->setArguments([
        new Reference(Client::class),
        '%config%',
    ]);
$container->autowire(FixtureService::class)
    ->setFactory([FixtureServiceFactory::class, 'create'])
    ->setArguments([
        new Reference(EntityManagerInterface::class),
        '%config%',
    ]);
$container->autowire(OrderService::class);
$container->autowire(ProductService::class);
// repository
$container->autowire(ProductRepository::class)
    ->setFactory([ProductRepositoryFactory::class, 'create'])
    ->setArguments([
        $container,
    ]);
$container->autowire(OrderRepository::class)
    ->setFactory([OrderRepositoryFactory::class, 'create'])
    ->setArguments([
        $container,
    ]);
$container->autowire(UserRepositoryInterface::class, DummyUserRepository::class);
// controller
$container->autowire(OrderController::class, OrderController::class)->setLazy(true)->setPublic(true);
$container->autowire(ProductController::class, ProductController::class)->setLazy(true)->setPublic(true);
// resolver
$container->autowire(ValidatorValueResolver::class);
$container->autowire(OrderServiceValueResolver::class);
$container->autowire(ProductServiceValueResolver::class);
// app
$container->register(ArgumentResolverInterface::class, ArgumentResolver::class)
    ->setArguments([
        null,
        array_merge(
            (array)ArgumentResolver::getDefaultArgumentValueResolvers(),
            [
                new Reference(OrderServiceValueResolver::class),
                new Reference(ProductServiceValueResolver::class),
                new Reference(ValidatorValueResolver::class),
            ]
        ),
    ]);
$container->setParameter('routes', include __DIR__ . '/routes.php');
$container->autowire(RequestContext::class);
$container->register('matcher', UrlMatcher::class)
    ->setArguments([
        '%routes%',
        new Reference(RequestContext::class),
    ]);
$container->register(RequestStack::class, RequestStack::class);
$container->register(ControllerResolverInterface::class, ControllerResolver::class);
$container->register('listener.router', RouterListener::class)
    ->setArguments([
        new Reference('matcher'),
        new Reference(RequestStack::class),
    ]);
$container->register('listener.response', ResponseListener::class)
    ->setArguments(['%charset%']);
$container->register('listener.error', ErrorListener::class)
    ->setArguments([[ErrorController::class, 'exception']]);
$container->register(EventDispatcherInterface::class, EventDispatcher::class)
    ->addMethodCall('addSubscriber', [new Reference('listener.router')])
    ->addMethodCall('addSubscriber', [new Reference('listener.response')])
    ->addMethodCall('addSubscriber', [new Reference('listener.error')]);
$container->autowire(Application::class)->setPublic(true);

$container->compile();

return $container;