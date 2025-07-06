<?php

declare(strict_types = 1);

namespace common\config;

/**
 * Вспомогательный класс для определения типа приложения
 */
class AppHelper
{
    /**
     * Список админ доменов
     */
    private const ADMIN_DOMAINS = [
        'admin.mii.local',
    ];

    /**
     * Определяет тип приложения по домену
     *
     * @return string
     */
    public static function getAppType(): string
    {
        $host = $_SERVER['HTTP_HOST'] ?? '';
        
        // Проверяем точное совпадение с админ доменами
        if (in_array($host, self::ADMIN_DOMAINS, true)) {
            return 'backend';
        }
        
        // Проверяем наличие 'admin' в домене
        if (strpos($host, 'admin') !== false) {
            return 'backend';
        }
        
        return 'frontend';
    }

    /**
     * Проверяет, является ли домен админским
     *
     * @return boolean
     */
    public static function isAdminDomain(): bool
    {
        return self::getAppType() === 'backend';
    }
} 