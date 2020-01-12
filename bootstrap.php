<?php

use Composer\Autoload\ClassLoader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Dotenv\Dotenv;

/** @var ClassLoader $loader */
$loader = include __DIR__ . '/vendor/autoload.php';

$dotEnv = Dotenv::createImmutable(__DIR__);
$dotEnv->load();

if (getenv('DEBUG')) {
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

AnnotationRegistry::registerLoader(function ($class) use ($loader) {
    return $loader->loadClass($class);
});

return include __DIR__ . '/config/container.php';