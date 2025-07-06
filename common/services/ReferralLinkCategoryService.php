<?php

declare(strict_types = 1);

namespace common\services;

use common\models\ReferralLinkCategory;
use common\enum\ReferralLinkCategoryStatusEnum;

/**
 * Сервис для работы с категориями реферальных ссылок
 */
class ReferralLinkCategoryService
{
    /**
     * Создать новую категорию
     */
    public function create($title, $description = null, $status = ReferralLinkCategoryStatusEnum::STATUS_ACTIVE, $prior = 0)
    {
        $category = new ReferralLinkCategory();
        $category->title = $title;
        $category->description = $description;
        $category->status = $status;
        $category->prior = $prior;

        if ($category->save()) {
            return $category;
        }

        return null;
    }

    /**
     * Обновить категорию
     */
    public function update($id, $title, $description = null, $status = null, $prior = null)
    {
        $category = ReferralLinkCategory::findOne($id);
        
        if (null === $category) {
            return null;
        }

        $category->title = $title;
        $category->description = $description;
        
        if ($status !== null) {
            $category->status = $status;
        }
        
        if ($prior !== null) {
            $category->prior = $prior;
        }

        if ($category->save()) {
            return $category;
        }

        return null;
    }

    /**
     * Удалить категорию
     */
    public function delete($id)
    {
        $category = ReferralLinkCategory::findOne($id);
        
        if (null === $category) {
            return false;
        }

        return (false !== $category->delete());
    }

    /**
     * Получить категорию по ID
     */
    public function getById($id)
    {
        return ReferralLinkCategory::findOne($id);
    }

    /**
     * Получить все активные категории
     */
    public function getActiveCategories()
    {
        return ReferralLinkCategory::find()->active()->byPriority()->all();
    }

    /**
     * Получить все категории
     */
    public function getAllCategories()
    {
        return ReferralLinkCategory::find()->byPriority()->all();
    }

    /**
     * Активировать категорию
     */
    public function activate($id)
    {
        $category = ReferralLinkCategory::findOne($id);
        
        if (null === $category) {
            return false;
        }

        $category->status = ReferralLinkCategoryStatusEnum::STATUS_ACTIVE;
        return $category->save();
    }

    /**
     * Деактивировать категорию
     */
    public function deactivate($id)
    {
        $category = ReferralLinkCategory::findOne($id);
        
        if (null === $category) {
            return false;
        }

        $category->status = ReferralLinkCategoryStatusEnum::STATUS_INACTIVE;
        return $category->save();
    }
} 