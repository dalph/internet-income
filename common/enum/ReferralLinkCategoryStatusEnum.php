<?php

declare(strict_types = 1);

namespace common\enum;

use common\enum\BaseEnum;

/**
 * Enum класс для статусов категорий реферальных ссылок
 */
class ReferralLinkCategoryStatusEnum extends BaseEnum
{
    /**
     * Статус неактивна
     */
    const STATUS_INACTIVE = 0;

    /**
     * Статус активна
     */
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritDoc}
     */
    public static function getMap(): array
    {
        return [
            self::STATUS_INACTIVE => 'Неактивна',
            self::STATUS_ACTIVE => 'Активна',
        ];
    }
} 