<?php

declare(strict_types = 1);

namespace common\tests\unit\enum;

use common\enum\ReferralLinkCategoryStatusEnum;

/**
 * Тест enum класса ReferralLinkCategoryStatusEnum
 */
class ReferralLinkCategoryStatusEnumTest extends \Codeception\Test\Unit
{
    /**
     * Тест констант статусов
     */
    public function testStatusConstants()
    {
        $this->assertEquals(0, ReferralLinkCategoryStatusEnum::STATUS_INACTIVE);
        $this->assertEquals(1, ReferralLinkCategoryStatusEnum::STATUS_ACTIVE);
    }

    /**
     * Тест методов BaseEnum
     */
    public function testBaseEnumMethods()
    {
        // Тест hasValue
        $this->assertTrue(ReferralLinkCategoryStatusEnum::hasValue(ReferralLinkCategoryStatusEnum::STATUS_ACTIVE));
        $this->assertTrue(ReferralLinkCategoryStatusEnum::hasValue(ReferralLinkCategoryStatusEnum::STATUS_INACTIVE));
        $this->assertFalse(ReferralLinkCategoryStatusEnum::hasValue(999));

        // Тест hasKey
        $this->assertTrue(ReferralLinkCategoryStatusEnum::hasKey('STATUS_ACTIVE'));
        $this->assertTrue(ReferralLinkCategoryStatusEnum::hasKey('STATUS_INACTIVE'));
        $this->assertFalse(ReferralLinkCategoryStatusEnum::hasKey('INVALID_KEY'));

        // Тест getValue
        $this->assertEquals(ReferralLinkCategoryStatusEnum::STATUS_ACTIVE, ReferralLinkCategoryStatusEnum::getValue('STATUS_ACTIVE'));
        $this->assertEquals(ReferralLinkCategoryStatusEnum::STATUS_INACTIVE, ReferralLinkCategoryStatusEnum::getValue('STATUS_INACTIVE'));

        // Тест getKey
        $this->assertEquals('STATUS_ACTIVE', ReferralLinkCategoryStatusEnum::getKey(ReferralLinkCategoryStatusEnum::STATUS_ACTIVE));
        $this->assertEquals('STATUS_INACTIVE', ReferralLinkCategoryStatusEnum::getKey(ReferralLinkCategoryStatusEnum::STATUS_INACTIVE));

        // Тест count
        $this->assertEquals(2, ReferralLinkCategoryStatusEnum::count());

        // Тест first и last
        $this->assertTrue(ReferralLinkCategoryStatusEnum::hasValue(ReferralLinkCategoryStatusEnum::first()));
        $this->assertTrue(ReferralLinkCategoryStatusEnum::hasValue(ReferralLinkCategoryStatusEnum::last()));
    }

    public function testGetTitles()
    {
        $titles = ReferralLinkCategoryStatusEnum::getTitles();
        $this->assertIsArray($titles);
        $this->assertEquals('Неактивна', $titles[ReferralLinkCategoryStatusEnum::STATUS_INACTIVE]);
        $this->assertEquals('Активна', $titles[ReferralLinkCategoryStatusEnum::STATUS_ACTIVE]);
    }

    public function testGetTitle()
    {
        $this->assertEquals('Неактивна', ReferralLinkCategoryStatusEnum::getTitle(ReferralLinkCategoryStatusEnum::STATUS_INACTIVE));
        $this->assertEquals('Активна', ReferralLinkCategoryStatusEnum::getTitle(ReferralLinkCategoryStatusEnum::STATUS_ACTIVE));
        $this->assertEquals('Неизвестно', ReferralLinkCategoryStatusEnum::getTitle(999));
    }
} 