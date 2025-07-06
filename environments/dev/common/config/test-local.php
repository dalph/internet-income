<?php

return [
    'id' => 'test-app',
    'basePath' => dirname(__DIR__, 2),
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=' . (getenv('DB_HOST') ?: 'localhost') . ';dbname=' . (getenv('DB_NAME') ?: 'internet_income_test'),
            'username' => getenv('DB_USER') ?: 'internet_income',
            'password' => getenv('DB_PASSWORD') ?: 'password',
            'charset' => 'utf8',
        ],
    ],
];
