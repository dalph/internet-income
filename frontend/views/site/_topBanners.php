<?php
/**
 * Верхние баннеры
 */

use common\widgets\BannersWidget;
?>

<?= BannersWidget::widget([
    'position' => 'top',
    'containerClass' => 'd-flex justify-content-center gap-3 mb-4',
    'bannerClass' => 'border rounded p-1 text-center bg-light',
    'imageClass' => 'img-fluid',
]) ?> 