<?php

declare(strict_types = 1);

namespace common\enum;

/**
 * Базовый класс для Enum
 */
abstract class BaseEnum
{
    /**
     * Получить список всех констант
     */
    public static function getConstants()
    {
        $reflection = new \ReflectionClass(static::class);
        return $reflection->getConstants();
    }

    /**
     * Получить список значений
     */
    public static function getValues()
    {
        return array_values(static::getConstants());
    }

    /**
     * Получить список ключей
     */
    public static function getKeys()
    {
        return array_keys(static::getConstants());
    }

    /**
     * Проверить, существует ли значение
     */
    public static function hasValue($value)
    {
        return in_array($value, static::getValues(), true);
    }

    /**
     * Проверить, существует ли ключ
     */
    public static function hasKey($key)
    {
        return array_key_exists($key, static::getConstants());
    }

    /**
     * Получить значение по ключу
     */
    public static function getValue($key)
    {
        $constants = static::getConstants();
        return $constants[$key] ?? null;
    }

    /**
     * Получить ключ по значению
     */
    public static function getKey($value)
    {
        $constants = static::getConstants();
        return array_search($value, $constants, true);
    }

    /**
     * Получить случайное значение
     */
    public static function random()
    {
        $values = static::getValues();
        return $values[array_rand($values)];
    }

    /**
     * Получить случайный ключ
     */
    public static function randomKey()
    {
        $keys = static::getKeys();
        return $keys[array_rand($keys)];
    }

    /**
     * Получить количество значений
     */
    public static function count()
    {
        return count(static::getConstants());
    }

    /**
     * Получить первый элемент
     */
    public static function first()
    {
        $values = static::getValues();
        return reset($values);
    }

    /**
     * Получить последний элемент
     */
    public static function last()
    {
        $values = static::getValues();
        return end($values);
    }

    /**
     * Получить первый ключ
     */
    public static function firstKey()
    {
        $keys = static::getKeys();
        return reset($keys);
    }

    /**
     * Получить последний ключ
     */
    public static function lastKey()
    {
        $keys = static::getKeys();
        return end($keys);
    }

    /**
     * Получить ассоциативный массив "значение => название" для всех констант
     * Должен быть реализован в каждом дочернем классе
     */
    abstract public static function getMap(): array;

    /**
     * Получить массив "значение => название" (алиас getMap)
     */
    public static function getTitles(): array
    {
        return static::getMap();
    }

    /**
     * Получить название по значению
     */
    public static function getTitle($value, ?string $notFoundTitle = 'Неизвестно'): string
    {
        $map = static::getMap();
        return $map[$value] ?? $notFoundTitle;
    }
} 