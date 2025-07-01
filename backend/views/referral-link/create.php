<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ReferralLink */

$this->title = 'Создать реферальную ссылку';
$this->params['breadcrumbs'][] = ['label' => 'Реферальные ссылки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="referral-link-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div> 