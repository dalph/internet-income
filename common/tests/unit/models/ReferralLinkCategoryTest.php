<?php

declare(strict_types = 1);

namespace common\tests\unit\models;

use common\models\ReferralLinkCategory;
use common\enum\ReferralLinkCategoryStatusEnum;
use common\tests\_support\BaseUnit;

/**
 * Тест для модели ReferralLinkCategory
 */
class ReferralLinkCategoryTest extends BaseUnit
{
    /**
     * Тест создания категории
     */
    public function testCreateCategory()
    {
        $category = new ReferralLinkCategory();
        $category->title = 'Тестовая категория';
        $category->description = 'Описание тестовой категории';
        $category->status = ReferralLinkCategoryStatusEnum::STATUS_ACTIVE;

        $this->assertTrue($category->save());
        $this->assertNotNull($category->id);
        $this->assertEquals('Тестовая категория', $category->title);
        $this->assertEquals('Описание тестовой категории', $category->description);
        $this->assertEquals(ReferralLinkCategoryStatusEnum::STATUS_ACTIVE, $category->status);
    }

    /**
     * Тест валидации обязательных полей
     */
    public function testValidationRequiredFields()
    {
        $category = new ReferralLinkCategory();
        
        $this->assertFalse($category->validate());
        $this->assertArrayHasKey('title', $category->errors);
    }

    /**
     * Тест валидации статуса
     */
    public function testValidationStatus()
    {
        $category = new ReferralLinkCategory();
        $category->title = 'Тестовая категория';
        $category->status = 999; // Неверный статус

        $this->assertFalse($category->validate());
        $this->assertArrayHasKey('status', $category->errors);
    }

    /**
     * Тест получения списка статусов
     */
    public function testGetStatusList()
    {
        $statusList = ReferralLinkCategory::getStatusList();
        
        $this->assertIsArray($statusList);
        $this->assertArrayHasKey(ReferralLinkCategoryStatusEnum::STATUS_ACTIVE, $statusList);
        $this->assertArrayHasKey(ReferralLinkCategoryStatusEnum::STATUS_INACTIVE, $statusList);
    }

    /**
     * Тест получения названия статуса
     */
    public function testGetStatusName()
    {
        $category = new ReferralLinkCategory();
        $category->status = ReferralLinkCategoryStatusEnum::STATUS_ACTIVE;
        
        $this->assertEquals('Активна', $category->getStatusName());
    }

    /**
     * Тест проверки активности
     */
    public function testIsActive()
    {
        $category = new ReferralLinkCategory();
        $category->status = ReferralLinkCategoryStatusEnum::STATUS_ACTIVE;
        
        $this->assertTrue($category->isActive());
        
        $category->status = ReferralLinkCategoryStatusEnum::STATUS_INACTIVE;
        $this->assertFalse($category->isActive());
    }

    /**
     * Тест связи с реферальными ссылками
     */
    public function testReferralLinksRelation()
    {
        $category = new ReferralLinkCategory();
        $this->assertInstanceOf('yii\db\ActiveQuery', $category->getReferralLinks());
    }

    /**
     * Тест связи с активными реферальными ссылками
     */
    public function testActiveReferralLinksRelation()
    {
        $category = new ReferralLinkCategory();
        $this->assertInstanceOf('yii\db\ActiveQuery', $category->getActiveReferralLinks());
    }
} 