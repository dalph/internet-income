<?php

declare(strict_types = 1);

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;
use yii\bootstrap5\BootstrapAsset;

/**
 * Main backend application asset bundle.
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
    ];
}
