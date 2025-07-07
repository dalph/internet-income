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
        $user->username = 'testuser';
        $user->email = 'test@example.com';
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
        $user->username = 'inactive_user';
        $user->email = 'inactive@example.com';
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
        $user->username = 'deleted_user';
        $user->email = 'deleted@example.com';
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
        $user = new User();
        $user->username = 'testuser';
        $user->email = 'test@example.com';
        $user->status = UserStatusEnum::ACTIVE;
        $user->auth_key = 'test_auth_key';
        $user->setPassword('password123');
        $user->save();

        $found = User::findByUsername('testuser');
        $this->assertInstanceOf(User::class, $found);
        $this->assertEquals('testuser', $found->username);
    }

    /**
     * Тест: findByUsername возвращает null для неактивного пользователя
     */
    public function testFindByUsernameInactiveUser()
    {
        $user = new User();
        $user->username = 'inactive_username';
        $user->email = 'inactive@example.com';
        $user->status = UserStatusEnum::INACTIVE;
        $user->auth_key = 'test_auth_key';
        $user->setPassword('password123');
        $user->save();

        $found = User::findByUsername('inactive_username');
        $this->assertNull($found);
    }

    /**
     * Тест: findByUsername возвращает null для удаленного пользователя
     */
    public function testFindByUsernameDeletedUser()
    {
        $user = new User();
        $user->username = 'deleted_username';
        $user->email = 'deleted@example.com';
        $user->status = UserStatusEnum::DELETED;
        $user->auth_key = 'test_auth_key';
        $user->setPassword('password123');
        $user->save();

        $found = User::findByUsername('deleted_username');
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
        $user->username = 'testuser';
        $user->email = 'test@example.com';
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