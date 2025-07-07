<?php

use Dotenv\Dotenv;

// Загружаем переменные окружения из .env файла
$envPath = dirname(dirname(__DIR__)) . '/.env';
if (file_exists($envPath)) {
    $dotenv = Dotenv::createImmutable(dirname(dirname(__DIR__)), null, true);
    $envArray = $dotenv->load();
    
    foreach ($envArray as $key => $value) {
        putenv("{$key}={$value}");
    }
}

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
