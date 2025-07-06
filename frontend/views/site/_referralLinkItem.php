<?php
/**
 * Выводит одну реферальную ссылку
 * @var array $link
 */
use yii\bootstrap5\Html;
?>
<div class="ref-link-block mb-2 d-flex align-items-center">
    <div class="flex-grow-1 me-2">
        <?= Html::a(
            $link['title'] ?? $link['url'],
            $link['url'],
            [
                'class' => 'btn btn-primary w-100 py-2' . (isset($link['is_top']) && $link['is_top'] ? ' btn-warning' : ''),
                'target' => '_blank'
            ]
        ) ?>
    </div>
    <div class="d-flex align-items-center">
        <?php if (isset($link['is_top']) && $link['is_top']): ?>
            <i class="fa fa-star text-warning me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Топовая ссылка - рекомендуемая для заработка"></i>
        <?php endif; ?>
        <?php if (false === empty($link['description'])): ?>
            <i class="fa fa-info-circle me-2" data-bs-toggle="tooltip" data-bs-placement="right" title="<?= Html::encode($link['description']) ?>"></i>
        <?php endif; ?>
    </div>
</div> 