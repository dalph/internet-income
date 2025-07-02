<?php

declare(strict_types = 1);

namespace common\tests\unit\models;

use common\models\ReferralLinkEnum;
use common\tests\UnitTester;

/**
 * Тест для ReferralLinkEnum
 */
class ReferralLinkEnumTest extends \Codeception\Test\Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * Тест получения списка статусов
     */
    public function testGetStatusList()
    {
        $statusList = ReferralLinkEnum::getStatusList();

        $this->assertIsArray($statusList);
        $this->assertArrayHasKey(ReferralLinkEnum::STATUS_INACTIVE, $statusList);
        $this->assertArrayHasKey(ReferralLinkEnum::STATUS_ACTIVE, $statusList);
        $this->assertEquals('Неактивен', $statusList[ReferralLinkEnum::STATUS_INACTIVE]);
        $this->assertEquals('Активен', $statusList[ReferralLinkEnum::STATUS_ACTIVE]);
    }

    /**
     * Тест получения названия статуса
     */
    public function testGetStatusName()
    {
        $this->assertEquals('Неактивен', ReferralLinkEnum::getStatusName(ReferralLinkEnum::STATUS_INACTIVE));
        $this->assertEquals('Активен', ReferralLinkEnum::getStatusName(ReferralLinkEnum::STATUS_ACTIVE));
        $this->assertEquals('Неизвестно', ReferralLinkEnum::getStatusName(999));
    }

    /**
     * Тест валидации статуса
     */
    public function testIsValidStatus()
    {
        $this->assertTrue(ReferralLinkEnum::isValidStatus(ReferralLinkEnum::STATUS_INACTIVE));
        $this->assertTrue(ReferralLinkEnum::isValidStatus(ReferralLinkEnum::STATUS_ACTIVE));
        $this->assertFalse(ReferralLinkEnum::isValidStatus(999));
        $this->assertFalse(ReferralLinkEnum::isValidStatus(-1));
        $this->assertFalse(ReferralLinkEnum::isValidStatus('invalid'));
    }

    /**
     * Тест констант статусов
     */
    public function testStatusConstants()
    {
        $this->assertEquals(0, ReferralLinkEnum::STATUS_INACTIVE);
        $this->assertEquals(1, ReferralLinkEnum::STATUS_ACTIVE);
    }
} 