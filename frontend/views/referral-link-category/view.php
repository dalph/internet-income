<?php

declare(strict_types = 1);

use common\enum\ReferralLinkStatusEnum;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var common\models\ReferralLinkCategory $category
 * @var common\models\ReferralLink[] $referralLinks
 */

$this->title = $category->title;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="referral-link-category-view">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="category-header mb-4">
                    <h1 class="text-center">
                        <i class="fa fa-folder text-primary"></i>
                        <?= Html::encode($category->title) ?>
                    </h1>
                    
                    <div class="text-center text-muted">
                        <p class="mb-0">
                            <i class="fa fa-link"></i>
                            <?= count($referralLinks) ?> реферальных ссылок
                        </p>
                    </div>
                </div>

                <?php if (empty($referralLinks)): ?>
                    <div class="alert alert-info text-center">
                        <i class="fa fa-info-circle"></i> В данной категории пока нет активных реферальных ссылок.
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($referralLinks as $link): ?>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <?php if ($link->is_top): ?>
                                        <div class="card-header bg-warning text-dark">
                                            <i class="fa fa-star"></i> Топовая ссылка
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <?= Html::encode($link->title) ?>
                                        </h5>
                                        
                                        <p class="card-text text-muted">
                                            <?= Html::encode($link->description) ?>
                                        </p>
                                        
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="badge bg-success">
                                                <i class="fa fa-check-circle"></i> 
                                                <?= ReferralLinkStatusEnum::getTitle($link->status) ?>
                                            </span>
                                            
                                            <?php if ($link->is_top): ?>
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fa fa-star"></i> Топ
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="d-grid">
                                            <?= Html::a(
                                                '<i class="fa fa-external-link-alt"></i> Перейти',
                                                $link->url,
                                                [
                                                    'class' => 'btn btn-primary',
                                                    'target' => '_blank',
                                                    'rel' => 'noopener noreferrer',
                                                ]
                                            ) ?>
                                        </div>
                                    </div>
                                    
                                    <div class="card-footer text-muted">
                                        <small>
                                            <i class="fa fa-calendar"></i>
                                            Добавлена: <?= Yii::$app->formatter->asDate($link->created_at) ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <div class="text-center mt-4">
                    <?= Html::a(
                        '<i class="fa fa-arrow-left"></i> Назад к категориям',
                        ['index'],
                        ['class' => 'btn btn-secondary']
                    ) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.category-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 10px;
    margin-bottom: 2rem;
}

.category-header h1 {
    color: white;
    margin-bottom: 0.5rem;
}

.card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.card-title {
    color: #2c3e50;
    font-weight: 600;
}

.card-header {
    font-weight: 600;
}

.badge {
    font-size: 0.8rem;
}

.btn-primary {
    background-color: #3498db;
    border-color: #3498db;
}

.btn-primary:hover {
    background-color: #2980b9;
    border-color: #2980b9;
}

.btn-secondary {
    background-color: #95a5a6;
    border-color: #95a5a6;
}

.btn-secondary:hover {
    background-color: #7f8c8d;
    border-color: #7f8c8d;
}
</style> 