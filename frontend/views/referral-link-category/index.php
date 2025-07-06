<?php

declare(strict_types = 1);

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var common\models\ReferralLinkCategory[] $categories
 */

$this->title = 'Категории реферальных ссылок';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="referral-link-category-index">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-5"><?= Html::encode($this->title) ?></h1>
                
                <?php if (empty($categories)): ?>
                    <div class="alert alert-info text-center">
                        <i class="fa fa-info-circle"></i> Категории реферальных ссылок пока не добавлены.
                    </div>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($categories as $category): ?>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fa fa-folder text-primary"></i>
                                            <?= Html::encode($category->title) ?>
                                        </h5>
                                        
                                        <p class="card-text text-muted">
                                            <small>
                                                <i class="fa fa-link"></i>
                                                <?= $category->getActiveReferralLinks()->count() ?> ссылок
                                            </small>
                                        </p>
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-success">
                                                <i class="fa fa-check-circle"></i> Активна
                                            </span>
                                            
                                            <?= Html::a(
                                                '<i class="fa fa-eye"></i> Просмотреть',
                                                ['view', 'id' => $category->id],
                                                ['class' => 'btn btn-primary btn-sm']
                                            ) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-5px);
}

.card-title {
    color: #2c3e50;
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
</style> 