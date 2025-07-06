<?php

return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/test-local.php',
    [
        'components' => [
            'request' => [
                'cookieValidationKey' => 'test_secret_key',
            ],
            'db' => [
                'class' => 'yii\\db\\Connection',
                'dsn' => 'mysql:host=db;dbname=internet_income_test',
                'username' => 'internet_income',
                'password' => 'password',
                'charset' => 'utf8',
            ],
        ],
    ]
);
