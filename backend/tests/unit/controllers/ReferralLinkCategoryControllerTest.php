<?php

declare(strict_types = 1);

namespace backend\tests\unit\controllers;

use backend\controllers\ReferralLinkCategoryController;
use common\models\ReferralLinkCategory;
use common\services\ReferralLinkCategoryService;
use common\tests\_support\BaseUnit;
use Yii;

/**
 * Тест контроллера категорий реферальных ссылок
 */
class ReferralLinkCategoryControllerTest extends BaseUnit
{
    /**
     * Тест создания контроллера
     */
    public function testControllerCreation()
    {
        $service = new ReferralLinkCategoryService();
        $controller = new ReferralLinkCategoryController('test', null, $service);
        
        $this->assertInstanceOf(ReferralLinkCategoryController::class, $controller);
    }

    /**
     * Тест поведения контроллера
     */
    public function testBehaviors()
    {
        $service = new ReferralLinkCategoryService();
        $controller = new ReferralLinkCategoryController('test', null, $service);
        
        $behaviors = $controller->behaviors();
        
        $this->assertArrayHasKey('verbs', $behaviors);
        $this->assertArrayHasKey('actions', $behaviors['verbs']);
        $this->assertArrayHasKey('delete', $behaviors['verbs']['actions']);
        $this->assertEquals(['POST'], $behaviors['verbs']['actions']['delete']);
    }

    /**
     * Тест метода findModel с существующим ID
     */
    public function testFindModelWithExistingId()
    {
        $service = new ReferralLinkCategoryService();
        $controller = new ReferralLinkCategoryController('test', null, $service);
        
        // Создаем тестовую категорию
        $category = $this->createTestModel(ReferralLinkCategory::class, [
            'title' => 'Test Category',
            'status' => 1,
            'prior' => 0,
        ]);
        $this->saveModel($category);
        
        $foundModel = $this->callProtectedMethod($controller, 'findModel', [(string) $category->id]);
        
        $this->assertInstanceOf(ReferralLinkCategory::class, $foundModel);
        $this->assertEquals($category->id, $foundModel->id);
        
        // Очистка
        $this->deleteModel($category);
    }

    /**
     * Тест метода findModel с несуществующим ID
     */
    public function testFindModelWithNonExistentId()
    {
        $service = new ReferralLinkCategoryService();
        $controller = new ReferralLinkCategoryController('test', null, $service);
        
        $this->expectException(\yii\web\NotFoundHttpException::class);
        $this->expectExceptionMessage('Категория не найдена.');
        
        $this->callProtectedMethod($controller, 'findModel', ['999999']);
    }

    /**
     * Тест метода findModel с null ID
     */
    public function testFindModelWithNullId()
    {
        $service = new ReferralLinkCategoryService();
        $controller = new ReferralLinkCategoryController('test', null, $service);
        
        $this->expectException(\yii\web\NotFoundHttpException::class);
        $this->expectExceptionMessage('Категория не найдена.');
        
        $this->callProtectedMethod($controller, 'findModel', [null]);
    }

    /**
     * Тест метода findModel с нечисловым ID
     */
    public function testFindModelWithNonNumericId()
    {
        $service = new ReferralLinkCategoryService();
        $controller = new ReferralLinkCategoryController('test', null, $service);
        
        $this->expectException(\yii\web\NotFoundHttpException::class);
        $this->expectExceptionMessage('Категория не найдена.');
        
        $this->callProtectedMethod($controller, 'findModel', ['invalid']);
    }
} 