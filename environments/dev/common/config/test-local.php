<?php

return [
    'id' => 'test-app',
    'basePath' => dirname(__DIR__, 2),
    'components' => [
        'db' => [
            'class' => 'yii\\db\\Connection',
            'dsn' => 'mysql:host=db;dbname=internet_income_test',
            'username' => 'internet_income',
            'password' => 'password',
            'charset' => 'utf8',
        ],
    ],
];
