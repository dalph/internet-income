<?php

namespace frontend\tests\unit\models;

use common\fixtures\UserFixture;
use common\enum\UserStatusEnum;
use frontend\models\VerifyEmailForm;
use common\tests\_support\BaseUnit;

class VerifyEmailFormTest extends BaseUnit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;


    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);
    }

    public function testVerifyWrongToken()
    {
        $this->tester->expectThrowable('\yii\base\InvalidArgumentException', function() {
            new VerifyEmailForm('');
        });

        $this->tester->expectThrowable('\yii\base\InvalidArgumentException', function() {
            new VerifyEmailForm('notexistingtoken_1391882543');
        });
    }

    public function testAlreadyActivatedToken()
    {
        $this->tester->expectThrowable('\yii\base\InvalidArgumentException', function() {
            new VerifyEmailForm('already_used_token_1548675330');
        });
    }

    public function testVerifyCorrectToken()
    {
        $model = new VerifyEmailForm('4ch0qbfhvWwkcuWqjN8SWRq72SOw1KYT_1548675330');
        $user = $model->verifyEmail();
        verify($user)->instanceOf('common\models\User');

        verify($user->username)->equals('test.test');
        verify($user->email)->equals('test@mail.com');
        verify($user->status)->equals(UserStatusEnum::ACTIVE);
        verify($user->validatePassword('Test1234'))->true();
    }
}
