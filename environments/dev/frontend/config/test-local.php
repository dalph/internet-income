<?php

return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/test-local.php',
    [
        // специфичные для frontend параметры, если появятся
    ]
);
