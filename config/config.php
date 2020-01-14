<?php

declare(strict_types=1);

return [
    'db' => [
        'dbname' => getenv('DB_NAME'),
        'user' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
        'host' => getenv('DB_HOST'),
        'port' => getenv('DB_PORT'),
        'driver' => getenv('DB_DRIVER'),
    ],
    'annotation_metadata_configuration' => [
        'paths' => [
            __DIR__ . '/../src/Application/Entity',
        ],
        'is_dev_mode' => true,
    ],
    'migration' => [
        'name' => 'Instrument Migrations',
        'namespace' => 'Migrations',
        'table_name' => 'doctrine_migration_versions',
        'column_length' => 255,
        'column_name' => 'version',
        'executed_at_column_name' => 'executed_at',
        'directory' => __DIR__ . '/../db/migrations',
        'all_or_nothing' => true,
        'check_database_platform' => false,
    ],
    'fixtures' => [
        'directory' => __DIR__ . '/../db/fixtures',
    ],
    'payment_system' => [
        'url' => getenv('PAYMENT_SYSTEM_URL'),
    ],
    'debug' => getenv('DEBUG'),
    'translator' => [
        'resource' => __DIR__ . '/../vendor/symfony/validator/Resources/translations/validators.ru.xlf',
    ],
];