<?php

declare(strict_types = 1);

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../common/config/bootstrap.php';

use common\config\AppHelper;
use common\config\ConfigLoader;
use yii\web\Application;

// Определяем тип приложения и загружаем конфигурацию
$appType = AppHelper::getAppType();
$basePath = dirname(__DIR__, 2);

$configLoader = new ConfigLoader($basePath, $appType);
$configLoader->loadBootstrap();
$config = $configLoader->load();

(new Application($config))->run();
