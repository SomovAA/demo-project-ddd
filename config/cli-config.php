<?php

declare(strict_types=1);

use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Tools\Console\Helper\ConfigurationHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Helper\HelperSet;

require __DIR__ . '/bootstrap.php';

/** @var EntityManagerInterface $entityManager */
$entityManager = $container->get('entityManager');

/** @var array $config */
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