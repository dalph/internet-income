<?php

declare(strict_types = 1);

namespace common\models;

use yii\db\ActiveQuery;
use common\enum\ReferralLinkCategoryStatusEnum;

/**
 * Класс запросов для модели ReferralLinkCategory
 */
class ReferralLinkCategoryQuery extends ActiveQuery
{
    /**
     * Фильтр по активным категориям
     */
    public function active()
    {
        return $this->andWhere([
            'status' => ReferralLinkCategoryStatusEnum::STATUS_ACTIVE
        ]);
    }

    /**
     * Фильтр по неактивным категориям
     */
    public function inactive()
    {
        return $this->andWhere([
            'status' => ReferralLinkCategoryStatusEnum::STATUS_INACTIVE
        ]);
    }

    /**
     * Сортировка по приоритету (высокий приоритет сначала)
     */
    public function byPriority()
    {
        return $this->orderBy(['prior' => SORT_DESC, 'id' => SORT_ASC]);
    }

    /**
     * Сортировка по дате создания (новые сначала)
     */
    public function latest()
    {
        return $this->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * Сортировка по дате создания (старые сначала)
     */
    public function oldest()
    {
        return $this->orderBy(['created_at' => SORT_ASC]);
    }

    /**
     * Фильтр по названию
     */
    public function byTitle($title)
    {
        return $this->andWhere(['like', 'title', $title]);
    }
} 