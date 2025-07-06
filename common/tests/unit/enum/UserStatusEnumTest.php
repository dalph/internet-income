<?php

declare(strict_types = 1);

namespace common\tests\unit\enum;

use common\enum\UserStatusEnum;
use common\tests\_support\BaseUnit;

/**
 * Тест для UserStatusEnum
 */
class UserStatusEnumTest extends BaseUnit
{
    /**
     * Тест констант статусов
     */
    public function testStatusConstants()
    {
        $this->assertEquals(0, UserStatusEnum::DELETED);
        $this->assertEquals(9, UserStatusEnum::INACTIVE);
        $this->assertEquals(10, UserStatusEnum::ACTIVE);
    }

    /**
     * Тест получения списка статусов
     */
    public function testGetTitles()
    {
        $titles = UserStatusEnum::getTitles();
        
        $this->assertIsArray($titles);
        $this->assertEquals('Удален', $titles[UserStatusEnum::DELETED]);
        $this->assertEquals('Неактивен', $titles[UserStatusEnum::INACTIVE]);
        $this->assertEquals('Активен', $titles[UserStatusEnum::ACTIVE]);
    }

    /**
     * Тест получения названия статуса
     */
    public function testGetTitle()
    {
        $this->assertEquals('Удален', UserStatusEnum::getTitle(UserStatusEnum::DELETED));
        $this->assertEquals('Неактивен', UserStatusEnum::getTitle(UserStatusEnum::INACTIVE));
        $this->assertEquals('Активен', UserStatusEnum::getTitle(UserStatusEnum::ACTIVE));
        $this->assertEquals('Неизвестно', UserStatusEnum::getTitle(999));
    }

    /**
     * Тест методов BaseEnum
     */
    public function testBaseEnumMethods()
    {
        // Тест hasValue
        $this->assertTrue(UserStatusEnum::hasValue(UserStatusEnum::DELETED));
        $this->assertTrue(UserStatusEnum::hasValue(UserStatusEnum::INACTIVE));
        $this->assertTrue(UserStatusEnum::hasValue(UserStatusEnum::ACTIVE));
        $this->assertFalse(UserStatusEnum::hasValue(999));

        // Тест hasKey
        $this->assertTrue(UserStatusEnum::hasKey('DELETED'));
        $this->assertTrue(UserStatusEnum::hasKey('INACTIVE'));
        $this->assertTrue(UserStatusEnum::hasKey('ACTIVE'));
        $this->assertFalse(UserStatusEnum::hasKey('INVALID_KEY'));

        // Тест getValue
        $this->assertEquals(UserStatusEnum::DELETED, UserStatusEnum::getValue('DELETED'));
        $this->assertEquals(UserStatusEnum::INACTIVE, UserStatusEnum::getValue('INACTIVE'));
        $this->assertEquals(UserStatusEnum::ACTIVE, UserStatusEnum::getValue('ACTIVE'));

        // Тест getKey
        $this->assertEquals('DELETED', UserStatusEnum::getKey(UserStatusEnum::DELETED));
        $this->assertEquals('INACTIVE', UserStatusEnum::getKey(UserStatusEnum::INACTIVE));
        $this->assertEquals('ACTIVE', UserStatusEnum::getKey(UserStatusEnum::ACTIVE));

        // Тест count
        $this->assertEquals(3, UserStatusEnum::count());

        // Тест first и last
        $this->assertTrue(UserStatusEnum::hasValue(UserStatusEnum::first()));
        $this->assertTrue(UserStatusEnum::hasValue(UserStatusEnum::last()));
    }
} 