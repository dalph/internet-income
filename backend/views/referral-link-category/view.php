<?php

declare(strict_types = 1);

use common\enum\ReferralLinkCategoryStatusEnum;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\ReferralLinkCategory $model
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Категории реферальных ссылок', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="referral-link-category-view">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1><?= Html::encode($this->title) ?></h1>
        <div>
            <?= Html::a(
                '<i class="fa fa-edit"></i> Редактировать',
                ['update', 'id' => $model->id],
                ['class' => 'btn btn-warning']
            ) ?>
            <?= Html::a(
                '<i class="fa fa-trash"></i> Удалить',
                ['delete', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить эту категорию?',
                        'method' => 'post',
                    ],
                ]
            ) ?>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
                'attribute' => 'status',
                'value' => ReferralLinkCategoryStatusEnum::getTitle($model->status),
            ],
            'prior',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <div class="mt-3">
        <?= Html::a(
            '<i class="fa fa-arrow-left"></i> Назад к списку',
            ['index'],
            ['class' => 'btn btn-secondary']
        ) ?>
    </div>
</div> 