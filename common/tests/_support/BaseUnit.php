<?php

declare(strict_types = 1);

namespace common\tests\_support;

use Codeception\Test\Unit;

/**
 * Базовый класс для всех unit тестов
 * 
 * Предоставляет общую функциональность для тестов:
 * - Настройка тестового окружения
 * - Общие вспомогательные методы
 * - Стандартные операции с моделями
 */
abstract class BaseUnit extends Unit
{
    /**
     * Настройка тестового окружения
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Очистка после тестов
     */
    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Вызвать защищённый метод через Reflection
     * 
     * @param object $object Объект, у которого вызывается метод
     * @param string $methodName Название метода
     * @param array $arguments Аргументы метода
     * @return mixed Результат выполнения метода
     */
    protected function callProtectedMethod($object, string $methodName, array $arguments = [])
    {
        $method = new \ReflectionMethod($object, $methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $arguments);
    }

    /**
     * Получить значение защищённого свойства через Reflection
     * 
     * @param object $object Объект, у которого получается свойство
     * @param string $propertyName Название свойства
     * @return mixed Значение свойства
     */
    protected function getProtectedProperty($object, string $propertyName)
    {
        $property = new \ReflectionProperty($object, $propertyName);
        $property->setAccessible(true);
        return $property->getValue($object);
    }

    /**
     * Установить значение защищённого свойства через Reflection
     * 
     * @param object $object Объект, у которого устанавливается свойство
     * @param string $propertyName Название свойства
     * @param mixed $value Значение свойства
     */
    protected function setProtectedProperty($object, string $propertyName, $value): void
    {
        $property = new \ReflectionProperty($object, $propertyName);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

    /**
     * Создать тестовую модель с базовыми данными
     * 
     * @param string $modelClass Класс модели
     * @param array $attributes Атрибуты модели
     * @return object Созданная модель
     */
    protected function createTestModel(string $modelClass, array $attributes = [])
    {
        $model = new $modelClass();
        
        foreach ($attributes as $attribute => $value) {
            $model->$attribute = $value;
        }
        
        return $model;
    }

    /**
     * Сохранить модель и вернуть её
     * 
     * @param object $model Модель для сохранения
     * @return object Сохранённая модель
     */
    protected function saveModel($model)
    {
        $this->assertTrue($model->save(), 'Модель должна сохраниться');
        return $model;
    }

    /**
     * Удалить модель
     * 
     * @param object $model Модель для удаления
     */
    protected function deleteModel($model): void
    {
        if ($model->id) {
            $model->delete();
        }
    }

    /**
     * Очистить все модели из базы данных
     * 
     * @param string $modelClass Класс модели
     */
    protected function clearModels(string $modelClass): void
    {
        $modelClass::deleteAll();
    }
} 