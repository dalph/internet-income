<?php
/**
 * Выводит одну реферальную ссылку
 * @var array $link
 */
use yii\bootstrap5\Html;
?>
<div class="ref-link-block mb-2">
    <?= Html::a(
        $link['title'] ?? $link['url'],
        $link['url'],
        [
            'class' => 'btn btn-primary py-2' . (isset($link['is_top']) && $link['is_top'] ? ' btn-warning' : ''),
            'target' => '_blank'
        ]
    ) ?>
    <?php if (isset($link['is_top']) && $link['is_top']): ?>
        <div class="ref-link-star">
            <i class="fa fa-star text-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Топовая ссылка - рекомендуемая для заработка"></i>
        </div>
    <?php else: ?>
        <div class="ref-link-star"></div>
    <?php endif; ?>
    <?php if (false === empty($link['description'])): ?>
        <div class="ref-link-info">
            <i class="fa fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="<?= Html::encode($link['description']) ?>"></i>
        </div>
    <?php else: ?>
        <div class="ref-link-info"></div>
    <?php endif; ?>
</div> 