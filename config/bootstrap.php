<?php

declare(strict_types=1);

use Composer\Autoload\ClassLoader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Dotenv\Dotenv;

/** @var ClassLoader $loader */
$loader = require dirname(__DIR__) . '/vendor/autoload.php';

if (!class_exists(Dotenv::class)) {
    throw new RuntimeException('Please run "composer require vlucas/phpdotenv" to load the ".env" files configuring the application.');
}

$dotEnv = Dotenv::createImmutable(dirname(__DIR__), ['.env']);
$dotEnv->load();

if (getenv('DEBUG')) {
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

AnnotationRegistry::registerLoader(function ($class) use ($loader) {
    return $loader->loadClass($class);
});

require __DIR__ . '/container.php';