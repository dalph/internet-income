<?php

declare(strict_types = 1);

use common\enum\ReferralLinkCategoryStatusEnum;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Категории реферальных ссылок';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="referral-link-category-index">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a(
            '<i class="fa fa-plus"></i> Создать категорию',
            ['create'],
            ['class' => 'btn btn-success']
        ) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'title',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return ReferralLinkCategoryStatusEnum::getTitle($model->status);
                },
                'filter' => ReferralLinkCategoryStatusEnum::getTitles(),
            ],
            'prior',
            'created_at:datetime',
            'updated_at:datetime',
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a(
                            '<i class="fa fa-eye"></i>',
                            $url,
                            [
                                'title' => 'Просмотр',
                                'class' => 'btn btn-sm btn-outline-primary',
                            ]
                        );
                    },
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<i class="fa fa-edit"></i>',
                            $url,
                            [
                                'title' => 'Редактировать',
                                'class' => 'btn btn-sm btn-outline-warning',
                            ]
                        );
                    },
                    'delete' => function ($url, $model) {
                        return Html::a(
                            '<i class="fa fa-trash"></i>',
                            $url,
                            [
                                'title' => 'Удалить',
                                'class' => 'btn btn-sm btn-outline-danger',
                                'data' => [
                                    'confirm' => 'Вы уверены, что хотите удалить эту категорию?',
                                    'method' => 'post',
                                ],
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>
</div> 