<?php

declare(strict_types = 1);

namespace common\tests\unit\models\user;

use common\models\User;
use common\tests\UnitTester;

/**
 * Базовые тесты для модели User
 * 
 * Дополнительные тесты разделены по категориям:
 * - UserIdentityTest - тесты идентификации
 * - UserValidationTest - тесты валидации
 * - UserTokenTest - тесты токенов
 */
class UserCommonTest extends \Codeception\Test\Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Тест: базовая проверка создания пользователя
     */
    public function testUserCreation()
    {
        $user = new User();
        $user->username = 'testuser';
        $user->email = 'test@example.com';
        $user->status = User::STATUS_ACTIVE;
        $user->auth_key = 'test_auth_key';
        $user->setPassword('password123');
        
        $this->assertTrue($user->save());
        $this->assertNotNull($user->id);
        $this->assertEquals('testuser', $user->username);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertEquals(User::STATUS_ACTIVE, $user->status);
    }

    /**
     * Тест: проверка констант статусов
     */
    public function testStatusConstants()
    {
        $this->assertEquals(0, User::STATUS_DELETED);
        $this->assertEquals(9, User::STATUS_INACTIVE);
        $this->assertEquals(10, User::STATUS_ACTIVE);
    }

    /**
     * Тест: проверка что модель реализует IdentityInterface
     */
    public function testImplementsIdentityInterface()
    {
        $user = new User();
        $this->assertInstanceOf(\yii\web\IdentityInterface::class, $user);
    }

    /**
     * Тест: проверка что модель наследует ActiveRecord
     */
    public function testExtendsActiveRecord()
    {
        $user = new User();
        $this->assertInstanceOf(\yii\db\ActiveRecord::class, $user);
    }
} 