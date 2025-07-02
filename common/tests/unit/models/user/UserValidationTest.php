<?php

declare(strict_types = 1);

namespace common\tests\unit\models\user;

use common\models\User;
use common\tests\UnitTester;

/**
 * Тест для валидации пользователя
 */
class UserValidationTest extends \Codeception\Test\Unit
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
     * Тест: setPassword и validatePassword
     */
    public function testSetAndValidatePassword()
    {
        $user = new User();
        $password = 'test_password_123';
        
        $user->setPassword($password);
        
        $this->assertTrue($user->validatePassword($password));
        $this->assertFalse($user->validatePassword('wrong_password'));
    }

    /**
     * Тест: validatePassword с пустым паролем
     */
    public function testValidatePasswordEmpty()
    {
        $user = new User();
        $user->setPassword('realpass');
        $this->expectException(\yii\base\InvalidArgumentException::class);
        $user->validatePassword('');
    }

    /**
     * Тест: validatePassword с неверным паролем
     */
    public function testValidatePasswordWrong()
    {
        $user = new User();
        $user->setPassword('correct_password');
        
        $result = $user->validatePassword('wrong_password');
        $this->assertFalse($result);
    }

    /**
     * Тест: generateAuthKey
     */
    public function testGenerateAuthKey()
    {
        $user = new User();
        $user->generateAuthKey();
        
        $this->assertNotEmpty($user->auth_key);
        $this->assertIsString($user->auth_key);
    }

    /**
     * Тест: tableName
     */
    public function testTableName()
    {
        $user = new User();
        $this->assertEquals('{{%user}}', $user->tableName());
    }

    /**
     * Тест: behaviors
     */
    public function testBehaviors()
    {
        $user = new User();
        $behaviors = $user->behaviors();
        
        $this->assertIsArray($behaviors);
        $this->assertArrayHasKey(0, $behaviors);
        $this->assertEquals(\yii\behaviors\TimestampBehavior::class, $behaviors[0]);
    }

    /**
     * Тест: rules
     */
    public function testRules()
    {
        $user = new User();
        $rules = $user->rules();
        
        $this->assertIsArray($rules);
        $this->assertNotEmpty($rules);

        $foundStatusDefault = false;
        $foundStatusIn = false;
        $foundEmailEmail = false;
        $foundEmailRequired = false;
        $foundEmailString = false;
        $foundEmailUnique = false;
        $foundUsernameUnique = false;

        foreach ($rules as $rule) {
            if (is_array($rule) && count($rule) >= 2) {
                if ($rule[0] === 'status' && $rule[1] === 'default') {
                    $foundStatusDefault = true;
                }
                if ($rule[0] === 'status' && $rule[1] === 'in') {
                    $foundStatusIn = true;
                }
                if ($rule[0] === 'email' && $rule[1] === 'email') {
                    $foundEmailEmail = true;
                }
                if ($rule[0] === 'email' && $rule[1] === 'required') {
                    $foundEmailRequired = true;
                }
                if ($rule[0] === 'email' && $rule[1] === 'string') {
                    $foundEmailString = true;
                }
                if ($rule[0] === 'email' && $rule[1] === 'unique') {
                    $foundEmailUnique = true;
                }
                if ($rule[0] === 'username' && $rule[1] === 'unique') {
                    $foundUsernameUnique = true;
                }
            }
        }

        $this->assertTrue($foundStatusDefault, 'Не найдено правило status default');
        $this->assertTrue($foundStatusIn, 'Не найдено правило status in');
        $this->assertTrue($foundEmailEmail, 'Не найдено правило email email');
        $this->assertTrue($foundEmailRequired, 'Не найдено правило email required');
        $this->assertTrue($foundEmailString, 'Не найдено правило email string');
        $this->assertTrue($foundEmailUnique, 'Не найдено правило email unique');
        $this->assertTrue($foundUsernameUnique, 'Не найдено правило username unique');
    }
} 