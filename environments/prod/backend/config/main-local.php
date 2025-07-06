<?php

return [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'prod-backend-secret-key-' . md5(__DIR__),
        ],
    ],
];
