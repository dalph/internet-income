<?php

return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/test-local.php',
    [
        'components' => [
            'request' => [
                'cookieValidationKey' => 'test_secret_key',
            ],
        ],
    ]
);
