<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\ReferralLinkEnum;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Реферальные ссылки';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="referral-link-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать реферальную ссылку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title:ntext',
            'url:url',
            'description:ntext',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->getStatusName();
                },
                'filter' => ReferralLinkEnum::getStatusList(),
            ],
            [
                'attribute' => 'is_top',
                'value' => function ($model) {
                    return $model->is_top ? 'Да' : 'Нет';
                },
                'filter' => [
                    1 => 'Да',
                    0 => 'Нет',
                ],
            ],
            'prior',
            'created_at:datetime',
            'updated_at:datetime',
            [
                'label' => 'Вкл/Выкл',
                'format' => 'raw',
                'value' => function ($model) {
                    $isActive = $model->status === \common\models\ReferralLinkEnum::STATUS_ACTIVE;
                    $icon = '<i class="fa fa-lightbulb-o" style="color: ' . ($isActive ? '#ffc107' : '#adb5bd') . ';"></i>';
                    $title = $isActive ? 'Отключить' : 'Включить';
                    return \yii\helpers\Html::a($icon, 'javascript:void(0);', [
                        'class' => 'js-toggle-status',
                        'title' => $title,
                        'data-id' => $model->id,
                        'data-status' => $isActive ? 0 : 1,
                        'style' => 'font-size: 1.5em; margin: 0 8px;'
                    ]);
                },
            ],
            [
                'label' => 'Топ',
                'format' => 'raw',
                'value' => function ($model) {
                    $isTop = $model->is_top;
                    $icon = $isTop
                        ? '<i class="fa fa-star" style="color: #ffc107;"></i>'
                        : '<i class="fa fa-star-o" style="color: #adb5bd;"></i>';
                    $title = $isTop ? 'Снять с топа' : 'Сделать топовой';
                    return \yii\helpers\Html::a($icon, 'javascript:void(0);', [
                        'class' => 'js-toggle-top',
                        'title' => $title,
                        'data-id' => $model->id,
                        'data-top' => $isTop ? 0 : 1,
                        'style' => 'font-size: 1.5em; margin: 0 8px;'
                    ]);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

<?php
// JS для ajax-переключателей
$js = <<<JS
jQuery(document).on('click', '.js-toggle-status', function() {
    var btn = jQuery(this);
    var id = btn.data('id');
    var status = btn.data('status');
    jQuery.post('/referral-link/change-status?id=' + id, {status: status}, function(resp) {
        if (resp.success) {
            $.pjax.reload({container: '#p0'});
        } else {
            alert(resp.message);
        }
    });
});

jQuery(document).on('click', '.js-toggle-top', function() {
    var btn = jQuery(this);
    var id = btn.data('id');
    var is_top = btn.data('top');
    jQuery.post('/referral-link/change-top-status?id=' + id, {is_top: is_top}, function(resp) {
        if (resp.success) {
            $.pjax.reload({container: '#p0'});
        } else {
            alert(resp.message);
        }
    });
});
JS;
$this->registerJs($js); 