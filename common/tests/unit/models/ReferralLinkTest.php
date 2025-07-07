<?php

declare(strict_types = 1);

namespace common\tests\unit\models;

use common\models\ReferralLink;
use common\enum\ReferralLinkStatusEnum;
use common\models\ReferralLinkCategory;
use common\enum\ReferralLinkCategoryStatusEnum;
use common\tests\_support\BaseUnit;

/**
 * Тест для модели ReferralLink
 */
class ReferralLinkTest extends BaseUnit
{
    /**
     * Тест создания реферальной ссылки
     */
    public function testCreateReferralLink()
    {
        $model = new ReferralLink();
        $model->title = 'Тестовая ссылка';
        $model->url = 'https://example.com';
        $model->description = 'Описание тестовой ссылки';
        $model->status = ReferralLinkStatusEnum::STATUS_ACTIVE;
        $model->is_top = true;
        $model->prior = 10;

        $this->assertTrue($model->save());
        $this->assertNotNull($model->id);
        $this->assertEquals('Тестовая ссылка', $model->title);
        $this->assertEquals('https://example.com', $model->url);
        $this->assertEquals(ReferralLinkStatusEnum::STATUS_ACTIVE, $model->status);
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
        $model->status = ReferralLinkStatusEnum::STATUS_ACTIVE;
        $this->assertTrue($model->isActive());
        $this->assertEquals('Активен', $model->getStatusName());

        // Тест неактивного статуса
        $model->status = ReferralLinkStatusEnum::STATUS_INACTIVE;
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

        $this->assertEquals(ReferralLinkStatusEnum::STATUS_ACTIVE, $model->status);
        $this->assertFalse($model->is_top);
        $this->assertEquals(0, $model->prior);
    }

    /**
     * Тест получения списка статусов
     */
    public function testGetStatusList()
    {
        $statusList = ReferralLink::getStatusList();
        
        $this->assertArrayHasKey(ReferralLinkStatusEnum::STATUS_INACTIVE, $statusList);
        $this->assertArrayHasKey(ReferralLinkStatusEnum::STATUS_ACTIVE, $statusList);
        $this->assertEquals('Неактивен', $statusList[ReferralLinkStatusEnum::STATUS_INACTIVE]);
        $this->assertEquals('Активен', $statusList[ReferralLinkStatusEnum::STATUS_ACTIVE]);
    }

    /**
     * Тест связи с категорией
     */
    public function testCategoryRelation()
    {
        $model = new ReferralLink();
        $this->assertInstanceOf('yii\db\ActiveQuery', $model->getCategory());
    }

    /**
     * Тест создания ссылки с категорией
     */
    public function testCreateWithCategory()
    {
        // Создаем категорию
        $category = new ReferralLinkCategory();
        $category->title = 'Тестовая категория';
        $category->status = ReferralLinkCategoryStatusEnum::STATUS_ACTIVE;
        $this->assertTrue($category->save());

        // Создаем ссылку с категорией
        $model = new ReferralLink();
        $model->title = 'Тестовая ссылка';
        $model->url = 'https://example.com';
        $model->category_id = $category->id;

        $this->assertTrue($model->save());
        $this->assertEquals($category->id, $model->category_id);
    }

    /**
     * Тест валидации несуществующей категории
     */
    public function testInvalidCategoryValidation()
    {
        $model = new ReferralLink();
        $model->title = 'Тестовая ссылка';
        $model->url = 'https://example.com';
        $model->category_id = 999; // Несуществующий ID

        $this->assertFalse($model->validate());
        $this->assertArrayHasKey('category_id', $model->errors);
    }
} 