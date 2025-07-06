<?php

declare(strict_types = 1);

namespace common\config;

/**
 * Вспомогательный класс для работы с переменными окружения
 */
class EnvHelper
{
    /**
     * Получает значение переменной окружения с fallback
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        return getenv($key) ?: $default;
    }

    /**
     * Получает строковое значение переменной окружения
     *
     * @param string $key
     * @param string $default
     * @return string
     */
    public static function getString(string $key, string $default = ''): string
    {
        return (string) self::get($key, $default);
    }

    /**
     * Получает булево значение переменной окружения
     *
     * @param string $key
     * @param boolean $default
     * @return boolean
     */
    public static function getBool(string $key, bool $default = false): bool
    {
        $value = self::get($key);
        
        if ($value === null) {
            return $default;
        }
        
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Получает целочисленное значение переменной окружения
     *
     * @param string $key
     * @param integer $default
     * @return integer
     */
    public static function getInt(string $key, int $default = 0): int
    {
        $value = self::get($key);
        
        if ($value === null) {
            return $default;
        }
        
        return (int) $value;
    }
} 