<?php

declare(strict_types = 1);

namespace common\tests\unit\enum;

use common\enum\ReferralLinkStatusEnum;
use common\tests\_support\BaseUnit;

/**
 * Тест для ReferralLinkStatusEnum
 */
class ReferralLinkStatusEnumTest extends BaseUnit
{
    /**
     * Тест констант статусов
     */
    public function testStatusConstants()
    {
        $this->assertEquals(0, ReferralLinkStatusEnum::STATUS_INACTIVE);
        $this->assertEquals(1, ReferralLinkStatusEnum::STATUS_ACTIVE);
    }

    /**
     * Тест методов BaseEnum
     */
    public function testBaseEnumMethods()
    {
        // Тест hasValue
        $this->assertTrue(ReferralLinkStatusEnum::hasValue(ReferralLinkStatusEnum::STATUS_ACTIVE));
        $this->assertTrue(ReferralLinkStatusEnum::hasValue(ReferralLinkStatusEnum::STATUS_INACTIVE));
        $this->assertFalse(ReferralLinkStatusEnum::hasValue(999));

        // Тест hasKey
        $this->assertTrue(ReferralLinkStatusEnum::hasKey('STATUS_ACTIVE'));
        $this->assertTrue(ReferralLinkStatusEnum::hasKey('STATUS_INACTIVE'));
        $this->assertFalse(ReferralLinkStatusEnum::hasKey('INVALID_KEY'));

        // Тест getValue
        $this->assertEquals(ReferralLinkStatusEnum::STATUS_ACTIVE, ReferralLinkStatusEnum::getValue('STATUS_ACTIVE'));
        $this->assertEquals(ReferralLinkStatusEnum::STATUS_INACTIVE, ReferralLinkStatusEnum::getValue('STATUS_INACTIVE'));

        // Тест getKey
        $this->assertEquals('STATUS_ACTIVE', ReferralLinkStatusEnum::getKey(ReferralLinkStatusEnum::STATUS_ACTIVE));
        $this->assertEquals('STATUS_INACTIVE', ReferralLinkStatusEnum::getKey(ReferralLinkStatusEnum::STATUS_INACTIVE));

        // Тест count
        $this->assertEquals(2, ReferralLinkStatusEnum::count());

        // Тест first и last
        $this->assertTrue(ReferralLinkStatusEnum::hasValue(ReferralLinkStatusEnum::first()));
        $this->assertTrue(ReferralLinkStatusEnum::hasValue(ReferralLinkStatusEnum::last()));
    }

    public function testGetTitles()
    {
        $titles = ReferralLinkStatusEnum::getTitles();
        $this->assertIsArray($titles);
        $this->assertEquals('Неактивен', $titles[ReferralLinkStatusEnum::STATUS_INACTIVE]);
        $this->assertEquals('Активен', $titles[ReferralLinkStatusEnum::STATUS_ACTIVE]);
    }

    public function testGetTitle()
    {
        $this->assertEquals('Неактивен', ReferralLinkStatusEnum::getTitle(ReferralLinkStatusEnum::STATUS_INACTIVE));
        $this->assertEquals('Активен', ReferralLinkStatusEnum::getTitle(ReferralLinkStatusEnum::STATUS_ACTIVE));
        $this->assertEquals('Неизвестно', ReferralLinkStatusEnum::getTitle(999));
    }
} 