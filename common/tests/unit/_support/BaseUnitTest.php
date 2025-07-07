<?php

declare(strict_types = 1);

namespace common\tests\unit\_support;

use common\models\ReferralLinkCategory;
use common\models\User;
use common\tests\_support\BaseUnit;

/**
 * Простой класс для тестирования protected свойств и методов
 */
class TestClass
{
    protected $testProperty = 'test_value';
    
    protected function testMethod()
    {
        return 'test_result';
    }
    
    protected function testMethodWithParams($param1, $param2)
    {
        return $param1 . '_' . $param2;
    }
}

/**
 * Тест для BaseUnit
 */
class BaseUnitTest extends BaseUnit
{
    /**
     * Тест вызова защищённого метода
     */
    public function testCallProtectedMethod(): void
    {
        $user = new User();
        $user->email = 'test@example.com';
        
        // Вызываем защищённый метод generateAuthKey
        $this->callProtectedMethod($user, 'generateAuthKey');
        
        // Проверяем, что auth_key был установлен
        $this->assertNotEmpty($user->auth_key);
    }

    /**
     * Тест вызова защищённого метода
     */
    public function testCallProtectedMethodSimple(): void
    {
        $testObject = new TestClass();
        
        $result = $this->callProtectedMethod($testObject, 'testMethod');
        
        $this->assertEquals('test_result', $result);
    }

    /**
     * Тест вызова защищённого метода с параметрами
     */
    public function testCallProtectedMethodWithParams(): void
    {
        $testObject = new TestClass();
        
        $result = $this->callProtectedMethod($testObject, 'testMethodWithParams', ['param1', 'param2']);
        
        $this->assertEquals('param1_param2', $result);
    }

    /**
     * Тест получения защищённого свойства
     */
    public function testGetProtectedProperty(): void
    {
        $testObject = new TestClass();
        
        // Получаем защищённое свойство
        $value = $this->getProtectedProperty($testObject, 'testProperty');
        
        $this->assertEquals('test_value', $value);
    }

    /**
     * Тест установки защищённого свойства
     */
    public function testSetProtectedProperty(): void
    {
        $testObject = new TestClass();
        
        // Устанавливаем защищённое свойство
        $this->setProtectedProperty($testObject, 'testProperty', 'new_value');
        
        $this->assertEquals('new_value', $this->getProtectedProperty($testObject, 'testProperty'));
    }

    /**
     * Тест сохранения модели
     */
    public function testSaveModel(): void
    {
        $category = $this->createTestModel(ReferralLinkCategory::class, [
            'title' => 'Test Category',
            'status' => 1,
            'prior' => 0,
        ]);
        
        $savedCategory = $this->saveModel($category);
        
        $this->assertNotNull($savedCategory->id);
        $this->assertTrue($savedCategory->isNewRecord === false);
        
        // Очистка
        $this->deleteModel($savedCategory);
    }

    /**
     * Тест удаления модели
     */
    public function testDeleteModel(): void
    {
        $category = $this->createTestModel(ReferralLinkCategory::class, [
            'title' => 'Test Category for Delete',
            'status' => 1,
            'prior' => 0,
        ]);
        
        $savedCategory = $this->saveModel($category);
        $categoryId = $savedCategory->id;
        
        $this->deleteModel($savedCategory);
        
        // Проверяем, что модель удалена
        $deletedCategory = ReferralLinkCategory::findOne($categoryId);
        $this->assertNull($deletedCategory);
    }

    /**
     * Тест очистки всех моделей
     */
    public function testClearModels(): void
    {
        // Создаём несколько категорий
        $category1 = $this->createTestModel(ReferralLinkCategory::class, [
            'title' => 'Category 1',
            'status' => 1,
            'prior' => 0,
        ]);
        $category2 = $this->createTestModel(ReferralLinkCategory::class, [
            'title' => 'Category 2',
            'status' => 1,
            'prior' => 1,
        ]);
        
        $this->saveModel($category1);
        $this->saveModel($category2);
        
        // Проверяем, что категории созданы
        $this->assertEquals(2, ReferralLinkCategory::find()->count());
        
        // Очищаем все категории
        $this->clearModels(ReferralLinkCategory::class);
        
        // Проверяем, что все категории удалены
        $this->assertEquals(0, ReferralLinkCategory::find()->count());
    }

    /**
     * Тест удаления модели без ID
     */
    public function testDeleteModelWithoutId(): void
    {
        $category = $this->createTestModel(ReferralLinkCategory::class, [
            'title' => 'Test Category',
            'status' => 1,
            'prior' => 0,
        ]);
        
        // Удаляем модель без ID (не сохранённую)
        $this->deleteModel($category);
        
        // Не должно быть ошибки
        $this->assertTrue(true);
    }
} 