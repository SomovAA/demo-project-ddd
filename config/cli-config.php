<?php

use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Tools\Console\Helper\ConfigurationHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\DependencyInjection\ContainerBuilder;

include __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../postautoload.php';

/** @var ContainerBuilder $container */
$container = include __DIR__ . '/container.php';

/** @var EntityManager $entityManager */
$entityManager = $container->get('entityManager');
$config = $container->getParameter('config')['migration'];

$migrationConfiguration = new Configuration($entityManager->getConnection());
$migrationConfiguration->setName($config['name']);
$migrationConfiguration->setMigrationsNamespace($config['namespace']);
$migrationConfiguration->setMigrationsTableName($config['table_name']);
$migrationConfiguration->setMigrationsColumnName($config['column_name']);
$migrationConfiguration->setMigrationsColumnLength($config['column_length']);
$migrationConfiguration->setMigrationsExecutedAtColumnName($config['executed_at_column_name']);
$migrationConfiguration->setMigrationsDirectory($config['directory']);
$migrationConfiguration->setAllOrNothing($config['all_or_nothing']);
$migrationConfiguration->setCheckDatabasePlatform($config['check_database_platform']);

$helperSet = new HelperSet();
$helperSet->set(new EntityManagerHelper($entityManager), 'em');
$helperSet->set(new ConnectionHelper($entityManager->getConnection()), 'db');
$helperSet->set(new ConfigurationHelper($entityManager->getConnection(), $migrationConfiguration));

return $helperSet;