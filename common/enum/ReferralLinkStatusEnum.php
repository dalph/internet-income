<?php

declare(strict_types = 1);

namespace common\enum;

use common\enum\BaseEnum;

/**
 * Enum класс для статусов реферальных ссылок
 */
class ReferralLinkStatusEnum extends BaseEnum
{
    /**
     * Статус неактивен
     */
    const STATUS_INACTIVE = 0;

    /**
     * Статус активен
     */
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritDoc}
     */
    public static function getMap(): array
    {
        return [
            self::STATUS_INACTIVE => 'Неактивен',
            self::STATUS_ACTIVE => 'Активен',
        ];
    }
} 