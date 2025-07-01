<?php

declare(strict_types = 1);

namespace console\controllers;

use common\models\User;
use Yii;

/**
 * Сидер для тестовых данных
 */
class SeedController extends BaseController
{
    /**
     * Запускает сидирование пользователей
     */
    public function actionIndex()
    {
        $this->info('Создание тестового пользователя...');
        $this->users();
    }

    /**
     * Создаёт тестового пользователя admin/admin123
     */
    public function users(): void
    {
        if (User::find()->where(['username' => 'admin'])->exists()) {
            $this->warning('Пользователь admin уже существует.');
            return;
        }

        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@example.com';
        $user->setPassword('admin123');
        $user->generateAuthKey();
        $user->status = 10;
        $user->created_at = time();
        $user->updated_at = time();

        if ($user->save()) {
            $this->info('Пользователь admin успешно создан.', $user->attributes);
        } else {
            $this->error('Ошибка при создании пользователя', $user->getErrors());
        }
    }
} 