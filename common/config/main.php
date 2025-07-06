<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
    ],
    'container' => [
        'definitions' => [
            \common\services\ReferralLinkService::class => [
                'class' => \common\services\ReferralLinkService::class,
            ],
            \common\services\ReferralLinkCategoryService::class => [
                'class' => \common\services\ReferralLinkCategoryService::class,
            ],
        ],
    ],
];
