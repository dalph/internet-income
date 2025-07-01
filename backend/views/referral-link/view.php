<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ReferralLink */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Реферальные ссылки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="referral-link-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить эту реферальную ссылку?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'url:url',
            'description:ntext',
            [
                'attribute' => 'status',
                'value' => $model->getStatusName(),
            ],
            [
                'attribute' => 'is_top',
                'value' => $model->is_top ? 'Да' : 'Нет',
            ],
            'prior',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div> 