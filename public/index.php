<?php

use Application\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;

/** @var ContainerBuilder $container */
$container = include __DIR__ . '/../bootstrap.php';

/** @var Application $application */
$application = $container->get('application');

$request = Request::createFromGlobals();
$response = $application->handle($request);
$response->send();