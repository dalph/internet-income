<?php

declare(strict_types = 1);

namespace common\tests\unit\services;

use common\services\ReferralLinkCategoryService;
use common\models\ReferralLinkCategory;
use common\enum\ReferralLinkCategoryStatusEnum;
use common\tests\UnitTester;

/**
 * Тест сервиса ReferralLinkCategoryService
 */
class ReferralLinkCategoryServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var UnitTester
     */
    protected UnitTester $tester;

    /**
     * @var ReferralLinkCategoryService
     */
    protected ReferralLinkCategoryService $service;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ReferralLinkCategoryService();
    }

    /**
     * Тест создания категории
     */
    public function testCreate()
    {
        $category = $this->service->create('Тестовая категория', 'Описание', ReferralLinkCategoryStatusEnum::STATUS_ACTIVE);
        
        $this->assertInstanceOf(ReferralLinkCategory::class, $category);
        $this->assertEquals('Тестовая категория', $category->title);
        $this->assertEquals('Описание', $category->description);
        $this->assertEquals(ReferralLinkCategoryStatusEnum::STATUS_ACTIVE, $category->status);
    }

    /**
     * Тест создания категории без описания
     */
    public function testCreateWithoutDescription()
    {
        $category = $this->service->create('Тестовая категория');
        
        $this->assertInstanceOf(ReferralLinkCategory::class, $category);
        $this->assertEquals('Тестовая категория', $category->title);
        $this->assertNull($category->description);
        $this->assertEquals(ReferralLinkCategoryStatusEnum::STATUS_ACTIVE, $category->status);
    }

    /**
     * Тест обновления категории
     */
    public function testUpdate()
    {
        $category = $this->service->create('Исходная категория', 'Исходное описание');
        $this->assertNotNull($category);
        
        $updatedCategory = $this->service->update($category->id, 'Обновленная категория', 'Обновленное описание');
        
        $this->assertInstanceOf(ReferralLinkCategory::class, $updatedCategory);
        $this->assertEquals('Обновленная категория', $updatedCategory->title);
        $this->assertEquals('Обновленное описание', $updatedCategory->description);
    }

    /**
     * Тест обновления несуществующей категории
     */
    public function testUpdateNonExistent()
    {
        $result = $this->service->update(999, 'Название', 'Описание');
        
        $this->assertNull($result);
    }

    /**
     * Тест удаления категории
     */
    public function testDelete()
    {
        $category = $this->service->create('Категория для удаления');
        $this->assertNotNull($category);
        
        $result = $this->service->delete($category->id);
        
        $this->assertTrue($result);
    }

    /**
     * Тест удаления несуществующей категории
     */
    public function testDeleteNonExistent()
    {
        $result = $this->service->delete(999);
        
        $this->assertFalse($result);
    }

    /**
     * Тест получения категории по ID
     */
    public function testGetById()
    {
        $category = $this->service->create('Тестовая категория');
        $this->assertNotNull($category);
        
        $foundCategory = $this->service->getById($category->id);
        
        $this->assertInstanceOf(ReferralLinkCategory::class, $foundCategory);
        $this->assertEquals($category->id, $foundCategory->id);
    }

    /**
     * Тест получения несуществующей категории
     */
    public function testGetByIdNonExistent()
    {
        $category = $this->service->getById(999);
        
        $this->assertNull($category);
    }

    /**
     * Тест активации категории
     */
    public function testActivate()
    {
        $category = $this->service->create('Тестовая категория', null, ReferralLinkCategoryStatusEnum::STATUS_INACTIVE);
        $this->assertNotNull($category);
        
        $result = $this->service->activate($category->id);
        
        $this->assertTrue($result);
        
        $updatedCategory = $this->service->getById($category->id);
        $this->assertEquals(ReferralLinkCategoryStatusEnum::STATUS_ACTIVE, $updatedCategory->status);
    }

    /**
     * Тест деактивации категории
     */
    public function testDeactivate()
    {
        $category = $this->service->create('Тестовая категория', null, ReferralLinkCategoryStatusEnum::STATUS_ACTIVE);
        $this->assertNotNull($category);
        
        $result = $this->service->deactivate($category->id);
        
        $this->assertTrue($result);
        
        $updatedCategory = $this->service->getById($category->id);
        $this->assertEquals(ReferralLinkCategoryStatusEnum::STATUS_INACTIVE, $updatedCategory->status);
    }

    /**
     * Тест получения всех активных категорий
     */
    public function testGetActiveCategories()
    {
        // Создаем активную категорию
        $activeCategory = $this->service->create('Активная категория', null, ReferralLinkCategoryStatusEnum::STATUS_ACTIVE);
        $this->assertNotNull($activeCategory);

        // Создаем неактивную категорию
        $inactiveCategory = $this->service->create('Неактивная категория', null, ReferralLinkCategoryStatusEnum::STATUS_INACTIVE);
        $this->assertNotNull($inactiveCategory);

        $activeCategories = $this->service->getActiveCategories();

        $this->assertIsArray($activeCategories);
        $this->assertCount(1, $activeCategories);
        $this->assertEquals(ReferralLinkCategoryStatusEnum::STATUS_ACTIVE, $activeCategories[0]->status);
    }

    /**
     * Тест получения всех категорий
     */
    public function testGetAllCategories()
    {
        // Создаем несколько категорий
        $category1 = $this->service->create('Категория 1', null, ReferralLinkCategoryStatusEnum::STATUS_ACTIVE, 10);
        $this->assertNotNull($category1);

        $category2 = $this->service->create('Категория 2', null, ReferralLinkCategoryStatusEnum::STATUS_INACTIVE, 5);
        $this->assertNotNull($category2);

        $allCategories = $this->service->getAllCategories();

        $this->assertIsArray($allCategories);
        $this->assertCount(2, $allCategories);
    }

    /**
     * Тест создания категории когда save возвращает false
     */
    public function testCreateWhenSaveReturnsFalse()
    {
        // Создаем категорию с неверными данными (пустое название)
        $category = $this->service->create('', 'Описание');

        $this->assertNull($category);
    }

    /**
     * Тест обновления категории когда save возвращает false
     */
    public function testUpdateWhenSaveReturnsFalse()
    {
        // Создаем категорию для обновления
        $category = $this->service->create('Исходная категория');
        $this->assertNotNull($category);

        // Пытаемся обновить с неверными данными (пустое название)
        $result = $this->service->update($category->id, '', 'Описание');

        $this->assertNull($result);
    }

    /**
     * Тест активации несуществующей категории
     */
    public function testActivateNonExistent()
    {
        $result = $this->service->activate(999);

        $this->assertFalse($result);
    }

    /**
     * Тест деактивации несуществующей категории
     */
    public function testDeactivateNonExistent()
    {
        $result = $this->service->deactivate(999);

        $this->assertFalse($result);
    }
} 