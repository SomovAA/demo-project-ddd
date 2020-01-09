<?php

use Dotenv\Dotenv;

$dotEnv = Dotenv::createImmutable(__DIR__);
$dotEnv->load();

if (getenv('DEBUG')) {
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}