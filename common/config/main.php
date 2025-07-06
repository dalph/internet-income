<?php

declare(strict_types = 1);

use yii\caching\FileCache;
use common\services\ReferralLinkService;
use common\services\ReferralLinkCategoryService;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => FileCache::class,
        ],
    ],
    'container' => [
        'definitions' => [
            ReferralLinkService::class => [
                'class' => ReferralLinkService::class,
            ],
            ReferralLinkCategoryService::class => [
                'class' => ReferralLinkCategoryService::class,
            ],
        ],
    ],
];
