<?php

declare(strict_types = 1);

namespace common\tests\unit\models\user;

use common\models\User;
use common\enum\UserStatusEnum;
use common\tests\_support\BaseUnit;

/**
 * Базовые тесты для модели User
 * 
 * Дополнительные тесты разделены по категориям:
 * - UserIdentityTest - тесты идентификации
 * - UserValidationTest - тесты валидации
 * - UserTokenTest - тесты токенов
 */
class UserCommonTest extends BaseUnit
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
        $user->status = UserStatusEnum::ACTIVE;
        $user->auth_key = 'test_auth_key';
        $user->setPassword('password123');
        
        $this->assertTrue($user->save());
        $this->assertNotNull($user->id);
        $this->assertEquals('testuser', $user->username);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertEquals(UserStatusEnum::ACTIVE, $user->status);
    }

    /**
     * Тест: проверка констант статусов
     */
    public function testStatusConstants()
    {
        $this->assertEquals(0, UserStatusEnum::DELETED);
        $this->assertEquals(9, UserStatusEnum::INACTIVE);
        $this->assertEquals(10, UserStatusEnum::ACTIVE);
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