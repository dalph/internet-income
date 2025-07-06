<?php

return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/test-local.php',
    [
        'components' => [
            'request' => [
                'cookieValidationKey' => 'test_secret_key',
            ],
            'db' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=' . (getenv('DB_HOST') ?: 'localhost') . ';dbname=' . (getenv('DB_NAME') ?: 'internet_income_test'),
                'username' => getenv('DB_USER') ?: 'internet_income',
                'password' => getenv('DB_PASSWORD') ?: 'password',
                'charset' => 'utf8',
            ],
        ],
    ]
);
