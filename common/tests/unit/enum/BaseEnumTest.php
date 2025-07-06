<?php

declare(strict_types = 1);

namespace common\tests\unit\enum;

use common\enum\BaseEnum;
use common\enum\ReferralLinkStatusEnum;
use common\enum\ReferralLinkCategoryStatusEnum;

/**
 * Тестовый enum для тестирования BaseEnum
 */
class TestEnum extends BaseEnum
{
    const ACTIVE = 1;
    const INACTIVE = 0;

    /**
     * Получить карту значений
     */
    public static function getMap(): array
    {
        return [
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
        ];
    }
}

/**
 * Тест базового класса BaseEnum
 */
class BaseEnumTest extends \Codeception\Test\Unit
{
    /**
     * Тест получения констант
     */
    public function testGetConstants()
    {
        $constants = ReferralLinkStatusEnum::getConstants();
        
        $this->assertIsArray($constants);
        $this->assertArrayHasKey('STATUS_INACTIVE', $constants);
        $this->assertArrayHasKey('STATUS_ACTIVE', $constants);
        $this->assertEquals(0, $constants['STATUS_INACTIVE']);
        $this->assertEquals(1, $constants['STATUS_ACTIVE']);
    }

    /**
     * Тест получения значений
     */
    public function testGetValues()
    {
        $values = ReferralLinkStatusEnum::getValues();
        
        $this->assertIsArray($values);
        $this->assertContains(0, $values);
        $this->assertContains(1, $values);
        $this->assertCount(2, $values);
    }

    /**
     * Тест получения ключей
     */
    public function testGetKeys()
    {
        $keys = ReferralLinkStatusEnum::getKeys();
        
        $this->assertIsArray($keys);
        $this->assertContains('STATUS_INACTIVE', $keys);
        $this->assertContains('STATUS_ACTIVE', $keys);
        $this->assertCount(2, $keys);
    }

    /**
     * Тест проверки существования значения
     */
    public function testHasValue()
    {
        $this->assertTrue(ReferralLinkStatusEnum::hasValue(0));
        $this->assertTrue(ReferralLinkStatusEnum::hasValue(1));
        $this->assertFalse(ReferralLinkStatusEnum::hasValue(999));
        $this->assertFalse(ReferralLinkStatusEnum::hasValue('invalid'));
    }

    /**
     * Тест проверки существования ключа
     */
    public function testHasKey()
    {
        $this->assertTrue(ReferralLinkStatusEnum::hasKey('STATUS_INACTIVE'));
        $this->assertTrue(ReferralLinkStatusEnum::hasKey('STATUS_ACTIVE'));
        $this->assertFalse(ReferralLinkStatusEnum::hasKey('INVALID_KEY'));
    }

    /**
     * Тест получения значения по ключу
     */
    public function testGetValue()
    {
        $this->assertEquals(0, ReferralLinkStatusEnum::getValue('STATUS_INACTIVE'));
        $this->assertEquals(1, ReferralLinkStatusEnum::getValue('STATUS_ACTIVE'));
        $this->assertNull(ReferralLinkStatusEnum::getValue('INVALID_KEY'));
    }

    /**
     * Тест получения ключа по значению
     */
    public function testGetKey()
    {
        $this->assertEquals('STATUS_INACTIVE', ReferralLinkStatusEnum::getKey(0));
        $this->assertEquals('STATUS_ACTIVE', ReferralLinkStatusEnum::getKey(1));
        $this->assertFalse(ReferralLinkStatusEnum::getKey(999));
    }

    /**
     * Тест получения случайного значения
     */
    public function testRandom()
    {
        $randomValue = ReferralLinkStatusEnum::random();
        
        $this->assertTrue(ReferralLinkStatusEnum::hasValue($randomValue));
    }

    /**
     * Тест получения случайного ключа
     */
    public function testRandomKey()
    {
        $randomKey = ReferralLinkStatusEnum::randomKey();
        
        $this->assertTrue(ReferralLinkStatusEnum::hasKey($randomKey));
    }

    /**
     * Тест получения количества значений
     */
    public function testCount()
    {
        $this->assertEquals(2, ReferralLinkStatusEnum::count());
        $this->assertEquals(2, ReferralLinkCategoryStatusEnum::count());
    }

    /**
     * Тест получения первого элемента
     */
    public function testFirst()
    {
        $first = ReferralLinkStatusEnum::first();
        
        $this->assertTrue(ReferralLinkStatusEnum::hasValue($first));
    }

    /**
     * Тест получения последнего элемента
     */
    public function testLast()
    {
        $last = ReferralLinkStatusEnum::last();
        
        $this->assertTrue(ReferralLinkStatusEnum::hasValue($last));
    }

    /**
     * Тест получения первого ключа
     */
    public function testFirstKey()
    {
        $firstKey = ReferralLinkStatusEnum::firstKey();
        
        $this->assertTrue(ReferralLinkStatusEnum::hasKey($firstKey));
    }

    /**
     * Тест получения последнего ключа
     */
    public function testLastKey()
    {
        $lastKey = ReferralLinkStatusEnum::lastKey();
        
        $this->assertTrue(ReferralLinkStatusEnum::hasKey($lastKey));
    }

    /**
     * Тест работы с разными Enum классами
     */
    public function testDifferentEnumClasses()
    {
        // Проверяем, что разные Enum классы работают независимо
        $this->assertEquals(2, ReferralLinkStatusEnum::count());
        $this->assertEquals(2, ReferralLinkCategoryStatusEnum::count());
        
        $this->assertTrue(ReferralLinkStatusEnum::hasValue(0));
        $this->assertTrue(ReferralLinkCategoryStatusEnum::hasValue(0));
        
        // Проверяем, что константы не смешиваются
        $referralLinkConstants = ReferralLinkStatusEnum::getConstants();
        $categoryConstants = ReferralLinkCategoryStatusEnum::getConstants();
        
        // Константы одинаковые, но это нормально для статусов
        $this->assertEquals($referralLinkConstants, $categoryConstants);
    }

    public function testGetTitle()
    {
        $this->assertEquals('Active', TestEnum::getTitle(TestEnum::ACTIVE));
        $this->assertEquals('Inactive', TestEnum::getTitle(TestEnum::INACTIVE));
        $this->assertEquals('Неизвестно', TestEnum::getTitle(999));
    }

    public function testGetTitleWithCustomNotFoundTitle()
    {
        $this->assertEquals('Active', TestEnum::getTitle(TestEnum::ACTIVE, 'Custom'));
        $this->assertEquals('Inactive', TestEnum::getTitle(TestEnum::INACTIVE, 'Custom'));
        $this->assertEquals('Custom', TestEnum::getTitle(999, 'Custom'));
        $this->assertEquals('', TestEnum::getTitle(999, ''));
    }
} 