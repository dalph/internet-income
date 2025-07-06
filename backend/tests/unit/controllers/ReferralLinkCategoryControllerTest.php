<?php

declare(strict_types = 1);

namespace backend\tests\unit\controllers;

use backend\controllers\ReferralLinkCategoryController;
use common\models\ReferralLinkCategory;
use common\services\ReferralLinkCategoryService;
use Codeception\Test\Unit;
use Yii;
use yii\web\Request;
use yii\web\Response;
use yii\web\Session;

/**
 * Тест контроллера категорий реферальных ссылок
 */
class ReferralLinkCategoryControllerTest extends Unit
{
    /**
     * Настройка тестового окружения
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Создаем тестовое приложение с необходимыми компонентами
        $config = [
            'id' => 'test-app',
            'basePath' => dirname(dirname(dirname(__DIR__))),
            'components' => [
                'db' => require dirname(dirname(dirname(dirname(__DIR__)))) . '/common/config/db.php',
                'request' => [
                    'class' => Request::class,
                    'enableCsrfValidation' => false,
                ],
                'response' => [
                    'class' => Response::class,
                ],
                'session' => [
                    'class' => Session::class,
                ],
            ],
        ];
        
        new \yii\console\Application($config);
    }

    /**
     * Очистка после тестов
     */
    protected function tearDown(): void
    {
        Yii::$app = null;
        parent::tearDown();
    }

    /**
     * Вызвать защищённый метод findModel через Reflection
     */
    private function callFindModel($controller, $id)
    {
        $method = new \ReflectionMethod($controller, 'findModel');
        $method->setAccessible(true);
        return $method->invoke($controller, $id);
    }

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
        $category = new ReferralLinkCategory();
        $category->title = 'Test Category';
        $category->status = 1;
        $category->prior = 0;
        $category->save();
        
        $foundModel = $this->callFindModel($controller, (string) $category->id);
        
        $this->assertInstanceOf(ReferralLinkCategory::class, $foundModel);
        $this->assertEquals($category->id, $foundModel->id);
        
        // Очистка
        $category->delete();
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
        
        $this->callFindModel($controller, '999999');
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
        
        $this->callFindModel($controller, null);
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
        
        $this->callFindModel($controller, 'invalid');
    }
} 