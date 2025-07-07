<?php
/**
 * Нижние баннеры
 */

use common\widgets\BannersWidget;
?>

<?= BannersWidget::widget([
    'position' => 'bottom',
    'containerClass' => 'd-flex justify-content-center gap-3 mt-4',
    'bannerClass' => 'border rounded p-1 text-center bg-light',
    'imageClass' => 'img-fluid',
]) ?> 