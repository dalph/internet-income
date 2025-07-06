<?php

declare(strict_types = 1);

/**
 * Единая конфигурация базы данных для всего приложения
 */
return [
    'class' => \yii\db\Connection::class,
    'dsn' => 'mysql:host=' . (getenv('DB_HOST') ?: 'db') . ';dbname=' . (getenv('DB_NAME') ?: 'internet_income_test'),
    'username' => getenv('DB_USER') ?: 'internet_income',
    'password' => getenv('DB_PASSWORD') ?: 'password',
    'charset' => 'utf8',
]; 