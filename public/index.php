<?php

use Application\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;

/** @var ContainerBuilder $container */
$container = require dirname(__DIR__) . '/config/bootstrap.php';

/** @var Application $application */
$application = $container->get('application');

$request = Request::createFromGlobals();
$response = $application->handle($request);
$response->send();