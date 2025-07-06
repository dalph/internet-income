<?php

declare(strict_types = 1);

namespace console\controllers;

use common\models\User;
use common\models\ReferralLinkCategory;
use common\models\ReferralLink;
use common\enum\UserStatusEnum;
use common\enum\ReferralLinkCategoryStatusEnum;
use common\enum\ReferralLinkStatusEnum;
use Yii;

/**
 * Сидер для тестовых данных
 */
class SeedController extends BaseController
{
    /**
     * Запускает полное сидирование данных
     */
    public function actionIndex()
    {
        $this->info('Начинаем создание тестовых данных...');
        
        $this->users();
        $this->referralLinkCategories();
        $this->referralLinks();
        
        $this->info('Сидирование завершено успешно!');
    }

    /**
     * Создаёт тестовых пользователей
     */
    public function actionUsers()
    {
        $this->info('Создание тестовых пользователей...');
        $this->users();
    }

    /**
     * Создаёт тестовые категории реферальных ссылок
     */
    public function actionCategories()
    {
        $this->info('Создание тестовых категорий реферальных ссылок...');
        $this->referralLinkCategories();
    }

    /**
     * Создаёт тестовые реферальные ссылки
     */
    public function actionLinks()
    {
        $this->info('Создание тестовых реферальных ссылок...');
        $this->referralLinks();
    }

    /**
     * Создаёт тестовых пользователей
     */
    private function users(): void
    {
        $this->info('Создание тестовых пользователей...');
        
        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => 'admin123',
                'status' => UserStatusEnum::ACTIVE,
            ],
            [
                'username' => 'user1',
                'email' => 'user1@example.com',
                'password' => 'user123',
                'status' => UserStatusEnum::ACTIVE,
            ],
            [
                'username' => 'user2',
                'email' => 'user2@example.com',
                'password' => 'user123',
                'status' => UserStatusEnum::INACTIVE,
            ],
            [
                'username' => 'moderator',
                'email' => 'moderator@example.com',
                'password' => 'mod123',
                'status' => UserStatusEnum::ACTIVE,
            ],
        ];

        foreach ($users as $userData) {
            if (User::find()->where(['username' => $userData['username']])->exists()) {
                $this->warning("Пользователь {$userData['username']} уже существует.");
                continue;
            }

            $user = new User();
            $user->username = $userData['username'];
            $user->email = $userData['email'];
            $user->setPassword($userData['password']);
            $user->generateAuthKey();
            $user->status = $userData['status'];
            $user->created_at = time();
            $user->updated_at = time();

            if ($user->save()) {
                $this->info("Пользователь {$userData['username']} успешно создан.");
            } else {
                $this->error("Ошибка при создании пользователя {$userData['username']}", $user->getErrors());
            }
        }
    }

    /**
     * Создаёт тестовые категории реферальных ссылок
     */
    private function referralLinkCategories(): void
    {
        $this->info('Создание тестовых категорий реферальных ссылок...');
        
        $categories = [
            [
                'title' => 'Криптовалюты',
                'description' => 'Реферальные ссылки на криптовалютные биржи и сервисы',
                'status' => ReferralLinkCategoryStatusEnum::STATUS_ACTIVE,
                'prior' => 1,
            ],
            [
                'title' => 'Форекс',
                'description' => 'Реферальные ссылки на форекс брокеров',
                'status' => ReferralLinkCategoryStatusEnum::STATUS_ACTIVE,
                'prior' => 2,
            ],
            [
                'title' => 'Бинарные опционы',
                'description' => 'Реферальные ссылки на платформы бинарных опционов',
                'status' => ReferralLinkCategoryStatusEnum::STATUS_ACTIVE,
                'prior' => 3,
            ],
            [
                'title' => 'Букмекеры',
                'description' => 'Реферальные ссылки на букмекерские конторы',
                'status' => ReferralLinkCategoryStatusEnum::STATUS_ACTIVE,
                'prior' => 4,
            ],
            [
                'title' => 'Казино',
                'description' => 'Реферальные ссылки на онлайн казино',
                'status' => ReferralLinkCategoryStatusEnum::STATUS_INACTIVE,
                'prior' => 5,
            ],
        ];

        foreach ($categories as $categoryData) {
            if (ReferralLinkCategory::find()->where(['title' => $categoryData['title']])->exists()) {
                $this->warning("Категория '{$categoryData['title']}' уже существует.");
                continue;
            }

            $category = new ReferralLinkCategory();
            $category->title = $categoryData['title'];
            $category->description = $categoryData['description'];
            $category->status = $categoryData['status'];
            $category->prior = $categoryData['prior'];
            $category->created_at = time();
            $category->updated_at = time();

            if ($category->save()) {
                $this->info("Категория '{$categoryData['title']}' успешно создана.");
            } else {
                $this->error("Ошибка при создании категории '{$categoryData['title']}'", $category->getErrors());
            }
        }
    }

    /**
     * Создаёт тестовые реферальные ссылки
     */
    private function referralLinks(): void
    {
        $this->info('Создание тестовых реферальных ссылок...');
        
        // Получаем категории для привязки ссылок
        $cryptoCategory = ReferralLinkCategory::find()->where(['title' => 'Криптовалюты'])->one();
        $forexCategory = ReferralLinkCategory::find()->where(['title' => 'Форекс'])->one();
        $binaryCategory = ReferralLinkCategory::find()->where(['title' => 'Бинарные опционы'])->one();
        $bookmakerCategory = ReferralLinkCategory::find()->where(['title' => 'Букмекеры'])->one();
        
        $links = [
            // Криптовалюты
            [
                'title' => 'Binance',
                'url' => 'https://www.binance.com/ru/register?ref=123456789',
                'description' => 'Крупнейшая криптовалютная биржа с низкими комиссиями',
                'category_id' => $cryptoCategory ? $cryptoCategory->id : null,
                'status' => ReferralLinkStatusEnum::STATUS_ACTIVE,
                'is_top' => true,
                'prior' => 1,
            ],
            [
                'title' => 'Bybit',
                'url' => 'https://www.bybit.com/invite?ref=987654321',
                'description' => 'Популярная биржа для торговли фьючерсами',
                'category_id' => $cryptoCategory ? $cryptoCategory->id : null,
                'status' => ReferralLinkStatusEnum::STATUS_ACTIVE,
                'is_top' => true,
                'prior' => 2,
            ],
            [
                'title' => 'OKX',
                'url' => 'https://www.okx.com/join/456789123',
                'description' => 'Международная криптовалютная биржа',
                'category_id' => $cryptoCategory ? $cryptoCategory->id : null,
                'status' => ReferralLinkStatusEnum::STATUS_ACTIVE,
                'is_top' => false,
                'prior' => 3,
            ],
            
            // Форекс
            [
                'title' => 'Alpari',
                'url' => 'https://alpari.com/ru/partners/ref/111222333',
                'description' => 'Надежный форекс брокер с многолетней историей',
                'category_id' => $forexCategory ? $forexCategory->id : null,
                'status' => ReferralLinkStatusEnum::STATUS_ACTIVE,
                'is_top' => true,
                'prior' => 1,
            ],
            [
                'title' => 'Forex4you',
                'url' => 'https://forex4you.com/partners/ref/444555666',
                'description' => 'Форекс брокер с выгодными условиями',
                'category_id' => $forexCategory ? $forexCategory->id : null,
                'status' => ReferralLinkStatusEnum::STATUS_ACTIVE,
                'is_top' => false,
                'prior' => 2,
            ],
            
            // Бинарные опционы
            [
                'title' => 'IQ Option',
                'url' => 'https://iqoption.com/ru/partners/ref/777888999',
                'description' => 'Популярная платформа для торговли бинарными опционами',
                'category_id' => $binaryCategory ? $binaryCategory->id : null,
                'status' => ReferralLinkStatusEnum::STATUS_ACTIVE,
                'is_top' => true,
                'prior' => 1,
            ],
            [
                'title' => 'Binary.com',
                'url' => 'https://binary.com/partners/ref/000111222',
                'description' => 'Старейшая платформа бинарных опционов',
                'category_id' => $binaryCategory ? $binaryCategory->id : null,
                'status' => ReferralLinkStatusEnum::STATUS_INACTIVE,
                'is_top' => false,
                'prior' => 2,
            ],
            
            // Букмекеры
            [
                'title' => '1xBet',
                'url' => 'https://1xbet.com/partners/ref/333444555',
                'description' => 'Крупная букмекерская контора с широкой линией',
                'category_id' => $bookmakerCategory ? $bookmakerCategory->id : null,
                'status' => ReferralLinkStatusEnum::STATUS_ACTIVE,
                'is_top' => true,
                'prior' => 1,
            ],
            [
                'title' => 'Bet365',
                'url' => 'https://bet365.com/partners/ref/666777888',
                'description' => 'Международная букмекерская контора',
                'category_id' => $bookmakerCategory ? $bookmakerCategory->id : null,
                'status' => ReferralLinkStatusEnum::STATUS_ACTIVE,
                'is_top' => false,
                'prior' => 2,
            ],
        ];

        foreach ($links as $linkData) {
            if (ReferralLink::find()->where(['title' => $linkData['title']])->exists()) {
                $this->warning("Ссылка '{$linkData['title']}' уже существует.");
                continue;
            }

            $link = new ReferralLink();
            $link->title = $linkData['title'];
            $link->url = $linkData['url'];
            $link->description = $linkData['description'];
            $link->category_id = $linkData['category_id'];
            $link->status = $linkData['status'];
            $link->is_top = $linkData['is_top'];
            $link->prior = $linkData['prior'];
            $link->created_at = time();
            $link->updated_at = time();

            if ($link->save()) {
                $this->info("Ссылка '{$linkData['title']}' успешно создана.");
            } else {
                $this->error("Ошибка при создании ссылки '{$linkData['title']}'", $link->getErrors());
            }
        }
    }

    /**
     * Очищает все тестовые данные
     */
    public function actionClear()
    {
        $this->info('Очистка тестовых данных...');
        
        // Удаляем реферальные ссылки
        $deletedLinks = ReferralLink::deleteAll();
        $this->info("Удалено реферальных ссылок: $deletedLinks");
        
        // Удаляем категории
        $deletedCategories = ReferralLinkCategory::deleteAll();
        $this->info("Удалено категорий: $deletedCategories");
        
        // Удаляем пользователей (кроме admin)
        $deletedUsers = User::deleteAll(['!=', 'username', 'admin']);
        $this->info("Удалено пользователей: $deletedUsers");
        
        $this->info('Очистка завершена!');
    }
} 