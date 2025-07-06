<?php

declare(strict_types = 1);

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;
use yii\bootstrap5\BootstrapAsset;
use yii\bootstrap5\BootstrapPluginAsset;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'libs/font-awesome/css/font-awesome.min.css',
    ];
    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
        BootstrapPluginAsset::class,
    ];
}
