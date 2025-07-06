<?php

declare(strict_types = 1);

namespace frontend\tests\unit\controllers;

use frontend\controllers\ReferralLinkCategoryController;
use common\models\ReferralLinkCategory;
use Codeception\Test\Unit;
use Yii;

/**
 * Тест фронтенд контроллера категорий реферальных ссылок
 */
class ReferralLinkCategoryControllerTest extends Unit
{
    /**
     * Тест создания контроллера
     */
    public function testControllerCreation()
    {
        $controller = new ReferralLinkCategoryController('test', null);
        
        $this->assertInstanceOf(ReferralLinkCategoryController::class, $controller);
    }

    /**
     * Тест метода findModel с существующим активным ID
     */
    public function testFindModelWithExistingActiveId()
    {
        $controller = new ReferralLinkCategoryController('test', null);
        
        // Создаем тестовую активную категорию
        $category = new ReferralLinkCategory();
        $category->title = 'Test Category';
        $category->status = 1; // Активная
        $category->prior = 0;
        $category->save();
        
        $foundModel = $controller->findModel((string) $category->id);
        
        $this->assertInstanceOf(ReferralLinkCategory::class, $foundModel);
        $this->assertEquals($category->id, $foundModel->id);
        $this->assertEquals(1, $foundModel->status); // Активная
        
        // Очистка
        $category->delete();
    }

    /**
     * Тест метода findModel с несуществующим ID
     */
    public function testFindModelWithNonExistentId()
    {
        $controller = new ReferralLinkCategoryController('test', null);
        
        $this->expectException(\yii\web\NotFoundHttpException::class);
        $this->expectExceptionMessage('Категория не найдена.');
        
        $controller->findModel('999999');
    }

    /**
     * Тест метода findModel с неактивной категорией
     */
    public function testFindModelWithInactiveCategory()
    {
        $controller = new ReferralLinkCategoryController('test', null);
        
        // Создаем тестовую неактивную категорию
        $category = new ReferralLinkCategory();
        $category->title = 'Test Inactive Category';
        $category->status = 0; // Неактивная
        $category->prior = 0;
        $category->save();
        
        $this->expectException(\yii\web\NotFoundHttpException::class);
        $this->expectExceptionMessage('Категория не найдена.');
        
        $controller->findModel((string) $category->id);
        
        // Очистка
        $category->delete();
    }

    /**
     * Тест метода findModel с null ID
     */
    public function testFindModelWithNullId()
    {
        $controller = new ReferralLinkCategoryController('test', null);
        
        $this->expectException(\yii\web\NotFoundHttpException::class);
        $this->expectExceptionMessage('Категория не найдена.');
        
        $controller->findModel(null);
    }

    /**
     * Тест метода findModel с нечисловым ID
     */
    public function testFindModelWithNonNumericId()
    {
        $controller = new ReferralLinkCategoryController('test', null);
        
        $this->expectException(\yii\web\NotFoundHttpException::class);
        $this->expectExceptionMessage('Категория не найдена.');
        
        $controller->findModel('invalid');
    }
} 