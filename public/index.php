<?php

declare(strict_types=1);

use Application\Application;
use Application\Service\SmartRequest;

require dirname(__DIR__) . '/config/bootstrap.php';

/** @var Application $application */
$application = $container->get(Application::class);

$request = SmartRequest::createFromGlobals();
$response = $application->handle($request);
$response->send();