<?php

use Application\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;

include __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../postautoload.php';

/** @var ContainerBuilder $container */
$container = include __DIR__ . '/../config/container.php';

/** @var Application $application */
$application = $container->get('application');

$request = Request::createFromGlobals();
$response = $application->handle($request);
$response->send();