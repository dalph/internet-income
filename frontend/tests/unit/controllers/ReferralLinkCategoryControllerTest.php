<?php

declare(strict_types = 1);

namespace frontend\tests\unit\controllers;

use frontend\controllers\ReferralLinkCategoryController;
use common\models\ReferralLinkCategory;
use common\tests\_support\BaseUnit;
use Yii;

/**
 * Тест фронтенд контроллера категорий реферальных ссылок
 */
class ReferralLinkCategoryControllerTest extends BaseUnit
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
        $category = $this->createTestModel(ReferralLinkCategory::class, [
            'title' => 'Test Category',
            'status' => 1, // Активная
            'prior' => 0,
        ]);
        $this->saveModel($category);
        
        $foundModel = $this->callProtectedMethod($controller, 'findModel', [(string) $category->id]);
        
        $this->assertInstanceOf(ReferralLinkCategory::class, $foundModel);
        $this->assertEquals($category->id, $foundModel->id);
        $this->assertEquals(1, $foundModel->status); // Активная
        
        // Очистка
        $this->deleteModel($category);
    }

    /**
     * Тест метода findModel с несуществующим ID
     */
    public function testFindModelWithNonExistentId()
    {
        $controller = new ReferralLinkCategoryController('test', null);
        
        $this->expectException(\yii\web\NotFoundHttpException::class);
        $this->expectExceptionMessage('Категория не найдена.');
        
        $this->callProtectedMethod($controller, 'findModel', ['999999']);
    }

    /**
     * Тест метода findModel с неактивной категорией
     */
    public function testFindModelWithInactiveCategory()
    {
        $controller = new ReferralLinkCategoryController('test', null);
        
        // Создаем тестовую неактивную категорию
        $category = $this->createTestModel(ReferralLinkCategory::class, [
            'title' => 'Test Inactive Category',
            'status' => 0, // Неактивная
            'prior' => 0,
        ]);
        $this->saveModel($category);
        
        $this->expectException(\yii\web\NotFoundHttpException::class);
        $this->expectExceptionMessage('Категория не найдена.');
        
        $this->callProtectedMethod($controller, 'findModel', [(string) $category->id]);
        
        // Очистка
        $this->deleteModel($category);
    }

    /**
     * Тест метода findModel с null ID
     */
    public function testFindModelWithNullId()
    {
        $controller = new ReferralLinkCategoryController('test', null);
        
        $this->expectException(\yii\web\NotFoundHttpException::class);
        $this->expectExceptionMessage('Категория не найдена.');
        
        $this->callProtectedMethod($controller, 'findModel', [null]);
    }

    /**
     * Тест метода findModel с нечисловым ID
     */
    public function testFindModelWithNonNumericId()
    {
        $controller = new ReferralLinkCategoryController('test', null);
        
        $this->expectException(\yii\web\NotFoundHttpException::class);
        $this->expectExceptionMessage('Категория не найдена.');
        
        $this->callProtectedMethod($controller, 'findModel', ['invalid']);
    }
} 