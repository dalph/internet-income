<?php

declare(strict_types = 1);

namespace common\tests\unit\models;

use common\models\LoginForm;
use common\models\User;
use common\enum\UserStatusEnum;
use common\tests\_support\BaseUnit;
use common\fixtures\UserFixture;
use Yii;

/**
 * Тест для модели LoginForm
 */
class LoginFormTest extends BaseUnit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;


    /**
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ];
    }

    public function testLoginNoUser()
    {
        $model = new LoginForm([
            'username' => 'not_existing_username',
            'password' => 'not_existing_password',
        ]);

        verify($model->login())->false();
        verify($model->errors)->arrayHasKey('password');
    }

    public function testLoginWrongPassword()
    {
        $model = new LoginForm([
            'username' => 'bayer.hudson',
            'password' => 'wrong_password',
        ]);

        verify($model->login())->false();
        verify($model->errors)->arrayHasKey('password');
    }

    public function testLoginCorrect()
    {
        $model = new LoginForm([
            'username' => 'bayer.hudson',
            'password' => 'password_0',
        ]);

        // Проверяем только валидацию, без входа в систему
        verify($model->validate())->true();
        verify($model->errors)->arrayHasNotKey('password');
        
        // Проверяем, что пользователь найден
        $user = $model->getUser();
        verify($user)->notNull();
        verify($user->username)->equals('bayer.hudson');
    }
}
