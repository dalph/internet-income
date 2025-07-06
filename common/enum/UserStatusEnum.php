<?php

declare(strict_types = 1);

namespace common\enum;

use common\enum\BaseEnum;

/**
 * Enum класс для статуса пользователей
 */
class UserStatusEnum extends BaseEnum
{
    /**
     * Статус удален
     */
    const DELETED = 0;

    /**
     * Статус неактивен
     */
    const INACTIVE = 9;

    /**
     * Статус активен
     */
    const ACTIVE = 10;

    /**
     * {@inheritDoc}
     */
    public static function getMap(): array
    {
        return [
            self::DELETED => 'Удален',
            self::INACTIVE => 'Неактивен',
            self::ACTIVE => 'Активен',
        ];
    }
} 