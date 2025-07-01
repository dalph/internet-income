<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $links common\models\ReferralLink[] */
/* @var $topLinks common\models\ReferralLink[] */

$this->title = 'Реферальные ссылки';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="referral-links-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (false === empty($topLinks)): ?>
        <div class="top-links">
            <h2>Топовые ссылки</h2>
            <div class="row">
                <?php foreach ($topLinks as $link): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= Html::encode($link->title) ?></h5>
                                <?php if (false === empty($link->description)): ?>
                                    <p class="card-text"><?= Html::encode($link->description) ?></p>
                                <?php endif; ?>
                                <a href="<?= Html::encode($link->url) ?>" target="_blank" class="btn btn-primary">
                                    Перейти
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (false === empty($links)): ?>
        <div class="all-links">
            <h2>Все ссылки</h2>
            <div class="row">
                <?php foreach ($links as $link): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= Html::encode($link->title) ?></h5>
                                <?php if (false === empty($link->description)): ?>
                                    <p class="card-text"><?= Html::encode($link->description) ?></p>
                                <?php endif; ?>
                                <a href="<?= Html::encode($link->url) ?>" target="_blank" class="btn btn-outline-primary">
                                    Перейти
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            Реферальные ссылки не найдены.
        </div>
    <?php endif; ?>

</div> 