<?php

declare(strict_types = 1);

namespace common\models;

/**
 * Enum класс для статусов реферальных ссылок
 */
class ReferralLinkEnum
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
     * Получить список статусов
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_INACTIVE => 'Неактивен',
            self::STATUS_ACTIVE => 'Активен',
        ];
    }

    /**
     * Получить название статуса
     */
    public static function getStatusName($status)
    {
        $statusList = self::getStatusList();
        return $statusList[$status] ?? 'Неизвестно';
    }

    /**
     * Проверить валидность статуса
     */
    public static function isValidStatus($status)
    {
        return in_array($status, [self::STATUS_INACTIVE, self::STATUS_ACTIVE]);
    }
} 