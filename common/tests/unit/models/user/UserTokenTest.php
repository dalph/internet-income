<?php

declare(strict_types = 1);

namespace common\tests\unit\models\user;

use common\models\User;
use common\enum\UserStatusEnum;
use common\tests\_support\BaseUnit;

/**
 * Тест для работы с токенами пользователя
 */
class UserTokenTest extends BaseUnit
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
     * Тест: findByPasswordResetToken
     */
    public function testFindByPasswordResetToken()
    {
        \Yii::$app->params['user.passwordResetTokenExpire'] = 3600;
        
        $user = new User();
        $user->username = 'testuser';
        $user->email = 'test@example.com';
        $user->status = UserStatusEnum::ACTIVE;
        $user->auth_key = 'test_auth_key';
        $user->setPassword('password123');
        $user->password_reset_token = 'valid_token_' . time();
        $user->save();

        $found = User::findByPasswordResetToken($user->password_reset_token);
        $this->assertInstanceOf(User::class, $found);
        $this->assertEquals($user->id, $found->id);
    }

    /**
     * Тест: findByPasswordResetToken возвращает null для неактивного пользователя
     */
    public function testFindByPasswordResetTokenInactiveUser()
    {
        \Yii::$app->params['user.passwordResetTokenExpire'] = 3600;
        
        $user = new User();
        $user->username = 'inactive_user';
        $user->email = 'inactive@example.com';
        $user->status = UserStatusEnum::INACTIVE;
        $user->auth_key = 'test_auth_key';
        $user->setPassword('password123');
        $user->password_reset_token = 'valid_token_' . time();
        $user->save();

        $found = User::findByPasswordResetToken($user->password_reset_token);
        $this->assertNull($found);
    }

    /**
     * Тест: findByPasswordResetToken возвращает null для удаленного пользователя
     */
    public function testFindByPasswordResetTokenDeletedUser()
    {
        \Yii::$app->params['user.passwordResetTokenExpire'] = 3600;
        
        $user = new User();
        $user->username = 'deleted_user';
        $user->email = 'deleted@example.com';
        $user->status = UserStatusEnum::DELETED;
        $user->auth_key = 'test_auth_key';
        $user->setPassword('password123');
        $user->password_reset_token = 'valid_token_' . time();
        $user->save();

        $found = User::findByPasswordResetToken($user->password_reset_token);
        $this->assertNull($found);
    }

    /**
     * Тест: findByPasswordResetToken возвращает null, если токен невалиден
     */
    public function testFindByPasswordResetTokenInvalid()
    {
        \Yii::$app->params['user.passwordResetTokenExpire'] = 3600;
        $found = User::findByPasswordResetToken('invalid_token_0');
        $this->assertNull($found);
    }

    /**
     * Тест: findByVerificationToken
     */
    public function testFindByVerificationToken()
    {
        $user = new User();
        $user->username = 'testuser';
        $user->email = 'test@example.com';
        $user->status = UserStatusEnum::INACTIVE;
        $user->auth_key = 'test_auth_key';
        $user->setPassword('password123');
        $user->verification_token = 'verification_token';
        $user->save();

        $found = User::findByVerificationToken('verification_token');
        $this->assertInstanceOf(User::class, $found);
        $this->assertEquals($user->id, $found->id);
    }

    /**
     * Тест: findByVerificationToken возвращает null для активного пользователя
     */
    public function testFindByVerificationTokenActiveUser()
    {
        $user = new User();
        $user->username = 'active_user';
        $user->email = 'active@example.com';
        $user->status = UserStatusEnum::ACTIVE;
        $user->auth_key = 'test_auth_key';
        $user->setPassword('password123');
        $user->verification_token = 'verification_token';
        $user->save();

        $found = User::findByVerificationToken('verification_token');
        $this->assertNull($found);
    }

    /**
     * Тест: findByVerificationToken возвращает null для удаленного пользователя
     */
    public function testFindByVerificationTokenDeletedUser()
    {
        $user = new User();
        $user->username = 'deleted_user';
        $user->email = 'deleted@example.com';
        $user->status = UserStatusEnum::DELETED;
        $user->auth_key = 'test_auth_key';
        $user->setPassword('password123');
        $user->verification_token = 'verification_token';
        $user->save();

        $found = User::findByVerificationToken('verification_token');
        $this->assertNull($found);
    }

    /**
     * Тест: findByVerificationToken возвращает null, если токен невалиден
     */
    public function testFindByVerificationTokenInvalid()
    {
        $found = User::findByVerificationToken('invalid_token');
        $this->assertNull($found);
    }

    /**
     * Тест: isPasswordResetTokenValid
     */
    public function testIsPasswordResetTokenValid()
    {
        \Yii::$app->params['user.passwordResetTokenExpire'] = 3600;
        
        $validToken = 'token_' . time();
        $this->assertTrue(User::isPasswordResetTokenValid($validToken));
    }

    /**
     * Тест: isPasswordResetTokenValid с пустым токеном
     */
    public function testIsPasswordResetTokenValidEmpty()
    {
        $this->assertFalse(User::isPasswordResetTokenValid(''));
    }

    /**
     * Тест: isPasswordResetTokenValid с просроченным токеном
     */
    public function testIsPasswordResetTokenValidExpired()
    {
        \Yii::$app->params['user.passwordResetTokenExpire'] = 3600;
        
        $expiredToken = 'token_' . (time() - 7200); // 2 часа назад
        $this->assertFalse(User::isPasswordResetTokenValid($expiredToken));
    }

    /**
     * Тест: generatePasswordResetToken
     */
    public function testGeneratePasswordResetToken()
    {
        \Yii::$app->params['user.passwordResetTokenExpire'] = 3600;
        
        $user = new User();
        $user->generatePasswordResetToken();
        
        $this->assertNotEmpty($user->password_reset_token);
        $this->assertIsString($user->password_reset_token);
        $this->assertTrue(User::isPasswordResetTokenValid($user->password_reset_token));
    }

    /**
     * Тест: generateEmailVerificationToken
     */
    public function testGenerateEmailVerificationToken()
    {
        $user = new User();
        $user->generateEmailVerificationToken();
        
        $this->assertNotEmpty($user->verification_token);
        $this->assertIsString($user->verification_token);
    }

    /**
     * Тест: removePasswordResetToken
     */
    public function testRemovePasswordResetToken()
    {
        $user = new User();
        $user->password_reset_token = 'some_token';
        $user->removePasswordResetToken();
        
        $this->assertNull($user->password_reset_token);
    }

    /**
     * Тест: removePasswordResetToken когда токен уже null
     */
    public function testRemovePasswordResetTokenWhenNull()
    {
        $user = new User();
        $user->password_reset_token = null;
        $user->removePasswordResetToken();
        
        $this->assertNull($user->password_reset_token);
    }
} 