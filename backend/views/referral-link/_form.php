<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ReferralLinkEnum;

/* @var $this yii\web\View */
/* @var $model common\models\ReferralLink */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="referral-link-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList(ReferralLinkEnum::getStatusList()) ?>

    <?= $form->field($model, 'is_top')->checkbox() ?>

    <?= $form->field($model, 'prior')->textInput(['type' => 'number']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div> 