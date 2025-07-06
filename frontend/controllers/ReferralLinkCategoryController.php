<?php

declare(strict_types = 1);

namespace frontend\controllers;

use common\models\ReferralLinkCategory;
use common\models\ReferralLinkCategoryQuery;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Контроллер для отображения категорий реферальных ссылок на фронтенде
 */
class ReferralLinkCategoryController extends Controller
{
    /**
     * Список активных категорий
     */
    public function actionIndex()
    {
        $categories = ReferralLinkCategory::find()
            ->active()
            ->orderBy(['prior' => SORT_ASC, 'id' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Просмотр категории с её реферальными ссылками
     */
    public function actionView(?string $id)
    {
        $category = $this->findModel($id);
        
        $referralLinks = $category->getActiveReferralLinks()
            ->orderBy(['is_top' => SORT_DESC, 'prior' => SORT_ASC, 'id' => SORT_DESC])
            ->all();

        return $this->render('view', [
            'category' => $category,
            'referralLinks' => $referralLinks,
        ]);
    }

    /**
     * Найти модель по ID
     */
    protected function findModel(?string $id): ReferralLinkCategory
    {
        $id = (int) $id;
        
        $model = ReferralLinkCategory::find()
            ->where(['id' => $id])
            ->active()
            ->one();
        
        if ($model === null) {
            throw new NotFoundHttpException('Категория не найдена.');
        }

        return $model;
    }
} 