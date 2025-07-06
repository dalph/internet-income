<?php

return [
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=' . (getenv('DB_HOST') ?: 'localhost') . ';dbname=' . (getenv('DB_NAME') ?: 'yii2advanced'),
            'username' => getenv('DB_USER') ?: 'root',
            'password' => getenv('DB_PASSWORD') ?: '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@common/mail',
        ],
    ],
];
