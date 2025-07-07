<?php
/**
 * Правая колонка с баннерами
 */

use common\widgets\BannersWidget;
?>

<?= BannersWidget::widget([
    'position' => 'right',
    'containerClass' => 'd-flex flex-column align-items-center gap-4',
    'bannerClass' => 'border rounded p-1 w-100 text-center bg-light',
    'imageClass' => 'img-fluid',
]) ?> 