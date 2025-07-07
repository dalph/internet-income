<?php
/**
 * Выводит список категорий реферальных ссылок и ссылки без категории
 * @var array $categories
 * @var array $linksWithoutCategory
 */
use yii\bootstrap5\Html;
?>

<?php if (false === empty($categories)): ?>
    <div class="categories-list">
        <?php foreach ($categories as $category): ?>
            <div class="category-item mb-2">
                <h4 class="category-title mb-1 d-flex align-items-center">
                    <?= Html::encode($category['title']) ?>
                    <?php if (false === empty($category['description'])): ?>
                        <span class="icon-info ms-2" data-bs-toggle="tooltip" data-bs-placement="right" title="<?= Html::encode($category['description']) ?>"></span>
                    <?php endif; ?>
                </h4>
                
                <?php if (false === empty($category['links'])): ?>
                    <?php
                    /**
                     * Если баннеры скрыты, выводит ссылки в две колонки
                     */
                    if (false === Yii::$app->params['showBanners']):
                    ?>
                        <div class="row row-cols-1 row-cols-md-2 g-3 category-links">
                            <?php foreach ($category['links'] as $link): ?>
                                <div class="col">
                                    <?= $this->render('_referralLinkItem', ['link' => $link]) ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="category-links">
                            <?php foreach ($category['links'] as $link): ?>
                                <?= $this->render('_referralLinkItem', ['link' => $link]) ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="text-muted small">В этой категории пока нет ссылок</div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php
/**
 * Выводит ссылки без категории
 */
if (false === empty($linksWithoutCategory)): ?>
    <div class="category-item mb-2">
        <?php
        /**
         * Если баннеры скрыты, выводит ссылки в две колонки
         */
        if (false === Yii::$app->params['showBanners']):
        ?>
            <div class="row row-cols-1 row-cols-md-2 g-3 category-links">
                <?php foreach ($linksWithoutCategory as $link): ?>
                    <div class="col">
                        <?= $this->render('_referralLinkItem', ['link' => $link]) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="category-links">
                <?php foreach ($linksWithoutCategory as $link): ?>
                    <?= $this->render('_referralLinkItem', ['link' => $link]) ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php
// JS для инициализации tooltip (Bootstrap 5)
$this->registerJs('
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll("[data-bs-toggle=\"tooltip\"]"));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
', \yii\web\View::POS_END);
?> 