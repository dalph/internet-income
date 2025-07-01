<?php

declare(strict_types = 1);

namespace common\models;

use yii\db\ActiveQuery;
use common\models\ReferralLinkEnum;

/**
 * Класс запросов для модели ReferralLink
 */
class ReferralLinkQuery extends ActiveQuery
{
    /**
     * Фильтр по активным ссылкам
     */
    public function active()
    {
        return $this->andWhere(['status' => ReferralLinkEnum::STATUS_ACTIVE]);
    }

    /**
     * Фильтр по неактивным ссылкам
     */
    public function inactive()
    {
        return $this->andWhere(['status' => ReferralLinkEnum::STATUS_INACTIVE]);
    }

    /**
     * Фильтр по топовым ссылкам
     */
    public function top()
    {
        return $this->andWhere(['is_top' => true]);
    }

    /**
     * Фильтр по обычным ссылкам (не топовые)
     */
    public function notTop()
    {
        return $this->andWhere(['is_top' => false]);
    }

    /**
     * Сортировка по топовым ссылкам и приоритету
     */
    public function byTopAndPriority()
    {
        return $this->orderBy(['is_top' => SORT_DESC, 'prior' => SORT_DESC, 'id' => SORT_ASC]);
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