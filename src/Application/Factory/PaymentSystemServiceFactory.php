<?php

namespace Application\Factory;

use Application\Service\PaymentSystemService;
use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PaymentSystemServiceFactory
{
    public static function create(ContainerInterface $container)
    {
        /** @var Client $client */
        $client = $container->get('client');

        /** @var array $config */
        $config = $container->getParameter('config');

        return new PaymentSystemService($client, $config);
    }
}