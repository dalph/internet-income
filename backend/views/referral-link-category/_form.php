<?php

declare(strict_types = 1);

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\ReferralLinkCategory $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'status')->dropDownList(
            \common\enum\ReferralLinkCategoryStatusEnum::getTitles(),
            ['prompt' => 'Выберите статус']
        ) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'prior')->textInput(['type' => 'number']) ?>
    </div>
</div>

<div class="form-group mt-3">
    <?= Html::submitButton(
        '<i class="fa fa-save"></i> Сохранить',
        ['class' => 'btn btn-success']
    ) ?>
    <?= Html::a(
        '<i class="fa fa-times"></i> Отмена',
        ['index'],
        ['class' => 'btn btn-secondary']
    ) ?>
</div> 