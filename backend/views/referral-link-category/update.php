<?php

declare(strict_types = 1);

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\ReferralLinkCategory $model
 */

$this->title = 'Редактировать категорию: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Категории реферальных ссылок', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>

<div class="referral-link-category-update">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $this->render('_form', [
                'model' => $model,
                'form' => $form,
            ]) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div> 