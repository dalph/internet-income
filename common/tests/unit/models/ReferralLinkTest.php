<?php

declare(strict_types = 1);

namespace common\tests\unit\models;

use common\models\ReferralLink;
use common\models\ReferralLinkEnum;
use common\tests\UnitTester;

/**
 * Тест для модели ReferralLink
 */
class ReferralLinkTest extends \Codeception\Test\Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * Тест создания реферальной ссылки
     */
    public function testCreateReferralLink()
    {
        $model = new ReferralLink();
        $model->title = 'Тестовая ссылка';
        $model->url = 'https://example.com';
        $model->description = 'Описание тестовой ссылки';
        $model->status = ReferralLinkEnum::STATUS_ACTIVE;
        $model->is_top = true;
        $model->prior = 10;

        $this->assertTrue($model->save());
        $this->assertNotNull($model->id);
        $this->assertEquals('Тестовая ссылка', $model->title);
        $this->assertEquals('https://example.com', $model->url);
        $this->assertEquals(ReferralLinkEnum::STATUS_ACTIVE, $model->status);
        $this->assertTrue($model->is_top);
        $this->assertEquals(10, $model->prior);
    }

    /**
     * Тест валидации обязательных полей
     */
    public function testRequiredFieldsValidation()
    {
        $model = new ReferralLink();
        
        // Тест без обязательных полей
        $this->assertFalse($model->validate());
        $this->assertArrayHasKey('title', $model->errors);
        $this->assertArrayHasKey('url', $model->errors);

        // Тест с обязательными полями
        $model->title = 'Тестовая ссылка';
        $model->url = 'https://example.com';
        
        $this->assertTrue($model->validate());
    }

    /**
     * Тест валидации URL
     */
    public function testUrlValidation()
    {
        $model = new ReferralLink();
        $model->title = 'Тестовая ссылка';

        // Неверный URL
        $model->url = 'invalid-url';
        $this->assertFalse($model->validate());
        $this->assertArrayHasKey('url', $model->errors);

        // Верный URL
        $model->url = 'https://example.com';
        $this->assertTrue($model->validate());
    }

    /**
     * Тест статусов ссылки
     */
    public function testStatusMethods()
    {
        $model = new ReferralLink();
        $model->title = 'Тестовая ссылка';
        $model->url = 'https://example.com';

        // Тест активного статуса
        $model->status = ReferralLinkEnum::STATUS_ACTIVE;
        $this->assertTrue($model->isActive());
        $this->assertEquals('Активен', $model->getStatusName());

        // Тест неактивного статуса
        $model->status = ReferralLinkEnum::STATUS_INACTIVE;
        $this->assertFalse($model->isActive());
        $this->assertEquals('Неактивен', $model->getStatusName());
    }

    /**
     * Тест топового статуса
     */
    public function testTopStatus()
    {
        $model = new ReferralLink();
        $model->title = 'Тестовая ссылка';
        $model->url = 'https://example.com';

        // Тест топовой ссылки
        $model->is_top = true;
        $this->assertTrue($model->isTop());

        // Тест обычной ссылки
        $model->is_top = false;
        $this->assertFalse($model->isTop());
    }

    /**
     * Тест значений по умолчанию
     */
    public function testDefaultValues()
    {
        $model = new ReferralLink();
        $model->title = 'Тестовая ссылка';
        $model->url = 'https://example.com';

        $this->assertTrue($model->save());

        $this->assertEquals(ReferralLinkEnum::STATUS_ACTIVE, $model->status);
        $this->assertFalse($model->is_top);
        $this->assertEquals(0, $model->prior);
    }

    /**
     * Тест получения списка статусов
     */
    public function testGetStatusList()
    {
        $statusList = ReferralLink::getStatusList();
        
        $this->assertArrayHasKey(ReferralLinkEnum::STATUS_INACTIVE, $statusList);
        $this->assertArrayHasKey(ReferralLinkEnum::STATUS_ACTIVE, $statusList);
        $this->assertEquals('Неактивен', $statusList[ReferralLinkEnum::STATUS_INACTIVE]);
        $this->assertEquals('Активен', $statusList[ReferralLinkEnum::STATUS_ACTIVE]);
    }
} 