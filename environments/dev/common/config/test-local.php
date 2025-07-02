<?php

return [
    'id' => 'test-app',
    'basePath' => dirname(__DIR__, 2),
    'components' => [
        'db' => [
            'class' => 'yii\\db\\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=internet_income_test',
            'username' => 'internet_income',
            'password' => 'password',
            'charset' => 'utf8',
        ],
    ],
];
