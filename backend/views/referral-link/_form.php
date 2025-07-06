<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\enum\ReferralLinkStatusEnum;
use yii\helpers\ArrayHelper;
use common\models\ReferralLinkCategory;

/* @var $this yii\web\View */
/* @var $model common\models\ReferralLink */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="referral-link-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?=
    // Выпадающий список категорий
    $form->field(
        $model,
        'category_id'
    )->dropDownList(
        ArrayHelper::map(
            ReferralLinkCategory::find()->active()->byPriority()->all(),
            'id',
            'title'
        ),
        [
            'prompt' => 'Выберите категорию'
        ]
    )
    ?>

    <?= $form->field($model, 'status')->dropDownList(ReferralLinkStatusEnum::getTitles()) ?>

    <?= $form->field($model, 'is_top')->checkbox() ?>

    <?= $form->field($model, 'prior')->textInput(['type' => 'number']) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i> Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div> 