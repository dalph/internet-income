# BaseEnum - Базовый класс для Enum

Базовый класс `BaseEnum` предоставляет удобные методы для работы с константами enum классов, аналогично Laravel Enum.

## Использование

### Создание Enum класса

```php
<?php

declare(strict_types = 1);

namespace common\enum;

use common\enum\BaseEnum;

class StatusEnum extends BaseEnum
{
    const ACTIVE = 1;
    const INACTIVE = 0;
    const PENDING = 2;
}
```

### Доступные методы

#### Получение констант и значений

- `getConstants()` - получить все константы класса
- `getValues()` - получить все значения констант
- `getKeys()` - получить все ключи констант
- `count()` - получить количество констант

#### Проверка существования

- `hasValue($value)` - проверить, существует ли значение
- `hasKey($key)` - проверить, существует ли ключ

#### Получение по ключу/значению

- `getValue($key)` - получить значение по ключу
- `getKey($value)` - получить ключ по значению

#### Случайные значения

- `random()` - получить случайное значение
- `randomKey()` - получить случайный ключ

#### Первый/последний элемент

- `first()` - получить первое значение
- `last()` - получить последнее значение
- `firstKey()` - получить первый ключ
- `lastKey()` - получить последний ключ

## Примеры использования

```php
// Получение всех констант
$constants = StatusEnum::getConstants();
// ['ACTIVE' => 1, 'INACTIVE' => 0, 'PENDING' => 2]

// Получение всех значений
$values = StatusEnum::getValues();
// [1, 0, 2]

// Проверка существования
StatusEnum::hasValue(1); // true
StatusEnum::hasKey('ACTIVE'); // true

// Получение по ключу/значению
StatusEnum::getValue('ACTIVE'); // 1
StatusEnum::getKey(1); // 'ACTIVE'

// Случайные значения
StatusEnum::random(); // случайное значение из [1, 0, 2]
StatusEnum::randomKey(); // случайный ключ из ['ACTIVE', 'INACTIVE', 'PENDING']

// Первый/последний
StatusEnum::first(); // первое значение
StatusEnum::last(); // последнее значение
StatusEnum::count(); // 3
```

## Расширение функциональности

Вы можете добавлять собственные методы в enum классы:

```php
class StatusEnum extends BaseEnum
{
    const ACTIVE = 1;
    const INACTIVE = 0;
    const PENDING = 2;

    /**
     * Получить список статусов с названиями
     */
    public static function getStatusList()
    {
        return [
            self::ACTIVE => 'Активен',
            self::INACTIVE => 'Неактивен',
            self::PENDING => 'В ожидании',
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
}
``` 