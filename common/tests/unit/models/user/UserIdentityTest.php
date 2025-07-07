<?php

declare(strict_types = 1);

namespace common\tests\unit\models\user;

use common\models\User;
use common\enum\UserStatusEnum;
use common\tests\_support\BaseUnit;

/**
 * Тест для методов идентификации пользователя
 */
class UserIdentityTest extends BaseUnit
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
     * Тест: findIdentity возвращает пользователя по ID
     */
    public function testFindIdentity()
    {
        $user = new User();
        $user->username = 'testuser_' . time();
        $user->email = 'test_' . time() . '@example.com';
        $user->status = UserStatusEnum::ACTIVE;
        $user->auth_key = 'test_auth_key';
        $user->setPassword('password123');
        $user->save();

        $found = User::findIdentity($user->id);
        $this->assertInstanceOf(User::class, $found);
        $this->assertEquals($user->id, $found->id);
    }

    /**
     * Тест: findIdentity возвращает null для неактивного пользователя
     */
    public function testFindIdentityInactiveUser()
    {
        $user = new User();
        $user->username = 'inactive_user_' . time();
        $user->email = 'inactive_' . time() . '@example.com';
        $user->status = UserStatusEnum::INACTIVE;
        $user->auth_key = 'test_auth_key';
        $user->setPassword('password123');
        $user->save();

        $found = User::findIdentity($user->id);
        $this->assertNull($found);
    }

    /**
     * Тест: findIdentity возвращает null для удаленного пользователя
     */
    public function testFindIdentityDeletedUser()
    {
        $user = new User();
        $user->username = 'deleted_user_' . time();
        $user->email = 'deleted_' . time() . '@example.com';
        $user->status = UserStatusEnum::DELETED;
        $user->auth_key = 'test_auth_key';
        $user->setPassword('password123');
        $user->save();

        $found = User::findIdentity($user->id);
        $this->assertNull($found);
    }

    /**
     * Тест: findIdentityByAccessToken выбрасывает исключение
     */
    public function testFindIdentityByAccessTokenThrowsException()
    {
        $this->expectException(\yii\base\NotSupportedException::class);
        User::findIdentityByAccessToken('token');
    }

    /**
     * Тест: findByUsername возвращает пользователя
     */
    public function testFindByUsername()
    {
        $username = 'testuser_' . time();
        $user = new User();
        $user->username = $username;
        $user->email = 'test_' . time() . '@example.com';
        $user->status = UserStatusEnum::ACTIVE;
        $user->auth_key = 'test_auth_key';
        $user->setPassword('password123');
        $user->save();

        $found = User::findByUsername($username);
        $this->assertInstanceOf(User::class, $found);
        $this->assertEquals($username, $found->username);
    }

    /**
     * Тест: findByUsername возвращает null для неактивного пользователя
     */
    public function testFindByUsernameInactiveUser()
    {
        $username = 'inactive_username_' . time();
        $user = new User();
        $user->username = $username;
        $user->email = 'inactive_' . time() . '@example.com';
        $user->status = UserStatusEnum::INACTIVE;
        $user->auth_key = 'test_auth_key';
        $user->setPassword('password123');
        $user->save();

        $found = User::findByUsername($username);
        $this->assertNull($found);
    }

    /**
     * Тест: findByUsername возвращает null для удаленного пользователя
     */
    public function testFindByUsernameDeletedUser()
    {
        $username = 'deleted_username_' . time();
        $user = new User();
        $user->username = $username;
        $user->email = 'deleted_' . time() . '@example.com';
        $user->status = UserStatusEnum::DELETED;
        $user->auth_key = 'test_auth_key';
        $user->setPassword('password123');
        $user->save();

        $found = User::findByUsername($username);
        $this->assertNull($found);
    }

    /**
     * Тест: findByUsername возвращает null, если пользователь не найден
     */
    public function testFindByUsernameNotFound()
    {
        $found = User::findByUsername('not-exist-user');
        $this->assertNull($found);
    }

    /**
     * Тест: getId возвращает ID пользователя
     */
    public function testGetId()
    {
        $user = new User();
        $user->username = 'testuser_' . time();
        $user->email = 'test_' . time() . '@example.com';
        $user->status = UserStatusEnum::ACTIVE;
        $user->auth_key = 'test_auth_key';
        $user->setPassword('password123');
        $user->save();

        $this->assertEquals($user->id, $user->getId());
    }

    /**
     * Тест: getAuthKey возвращает auth_key
     */
    public function testGetAuthKey()
    {
        $user = new User();
        $user->auth_key = 'test_auth_key';
        
        $this->assertEquals('test_auth_key', $user->getAuthKey());
    }

    /**
     * Тест: validateAuthKey с правильным ключом
     */
    public function testValidateAuthKey()
    {
        $user = new User();
        $user->auth_key = 'correct_key';
        
        $result = $user->validateAuthKey('correct_key');
        $this->assertTrue($result);
    }

    /**
     * Тест: validateAuthKey с неверным ключом
     */
    public function testValidateAuthKeyWrong()
    {
        $user = new User();
        $user->auth_key = 'correct_key';
        
        $result = $user->validateAuthKey('wrong_key');
        $this->assertFalse($result);
    }

    /**
     * Тест: validateAuthKey с null ключом
     */
    public function testValidateAuthKeyNull()
    {
        $user = new User();
        $user->auth_key = 'correct_key';
        
        $result = $user->validateAuthKey(null);
        $this->assertFalse($result);
    }

    /**
     * Тест: validateAuthKey с пустым ключом
     */
    public function testValidateAuthKeyEmpty()
    {
        $user = new User();
        $user->auth_key = 'correct_key';
        
        $result = $user->validateAuthKey('');
        $this->assertFalse($result);
    }

    /**
     * Тест: validateAuthKey с null auth_key
     */
    public function testValidateAuthKeyWithNullAuthKey()
    {
        $user = new User();
        $user->auth_key = null;
        
        $result = $user->validateAuthKey('any_key');
        $this->assertFalse($result);
    }

    /**
     * Тест: validateAuthKey с пустым auth_key
     */
    public function testValidateAuthKeyWithEmptyAuthKey()
    {
        $user = new User();
        $user->auth_key = '';
        
        $result = $user->validateAuthKey('any_key');
        $this->assertFalse($result);
    }
} 