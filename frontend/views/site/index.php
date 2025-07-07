<?php

/** @var yii\web\View $this */
/** @var array $topLinks */
/** @var array $categories */
/** @var array $linksWithoutCategory */

$this->title = Yii::$app->params['siteTitle'];
$this->context->layout = 'main';
?>
<div class="container py-5">
    <!-- Заголовок -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-5 fw-bold"><?= Yii::$app->params['siteTitle'] ?></h1>
        </div>
    </div>
    <!-- Топовые ссылки -->
    <?php if (false === empty($topLinks)): ?>
        <div class="row mb-4">
            <div class="col-12">
                <h3 class="mb-3 text-center">Топовые предложения</h3>
                <div class="top-links-row">
                    <?php foreach ($topLinks as $link): ?>
                        <?= $this->render('_referralLinkItem', ['link' => $link->toArray()]) ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row justify-content-center">
        <?php
        /**
         * Показывает две колонки, если разрешено showBanners, иначе одну колонку на всю ширину
         */
        if (true === Yii::$app->params['showBanners']):
        ?>
            <div class="col-md-5 mb-4 mb-md-0">
                <?php
                /**
                 * Показывает баннеры, если разрешено параметром showBanners
                 */
                echo $this->render('_leftBanners');
                ?>
            </div>
            <div class="col-md-5">
                <?= $this->render('_referralLinkCategories', [
                    'categories' => $categories,
                    'linksWithoutCategory' => $linksWithoutCategory,
                ]) ?>
            </div>
        <?php
        else:
        ?>
            <div class="col-12">
                <?= $this->render('_referralLinkCategories', [
                    'categories' => $categories,
                    'linksWithoutCategory' => $linksWithoutCategory,
                ]) ?>
            </div>
        <?php
        endif;
        ?>
    </div>
</div>
