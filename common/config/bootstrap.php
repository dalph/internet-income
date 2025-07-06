<?php

use Dotenv\Dotenv;

// Загружаем переменные окружения из .env файла
if (file_exists(dirname(dirname(__DIR__)) . '/.env')) {
    $dotenv = Dotenv::createImmutable(dirname(dirname(__DIR__)));
    $dotenv->load();
}

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
