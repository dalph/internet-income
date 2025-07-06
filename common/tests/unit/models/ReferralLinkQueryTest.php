<?php

declare(strict_types = 1);

namespace common\tests\unit\models;

use common\models\ReferralLink;
use common\enum\ReferralLinkStatusEnum;
use common\tests\UnitTester;

/**
 * Тест для ReferralLinkQuery
 */
class ReferralLinkQueryTest extends \Codeception\Test\Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * Тест фильтра активных ссылок
     */
    public function testActiveFilter()
    {
        // Создаем активную ссылку
        $activeLink = new ReferralLink();
        $activeLink->title = 'Активная ссылка';
        $activeLink->url = 'https://example.com';
        $activeLink->status = ReferralLinkStatusEnum::STATUS_ACTIVE;
        $activeLink->save();

        // Создаем неактивную ссылку
        $inactiveLink = new ReferralLink();
        $inactiveLink->title = 'Неактивная ссылка';
        $inactiveLink->url = 'https://example2.com';
        $inactiveLink->status = ReferralLinkStatusEnum::STATUS_INACTIVE;
        $inactiveLink->save();

        $activeLinks = ReferralLink::find()->active()->all();

        $this->assertCount(1, $activeLinks);
        $this->assertEquals('Активная ссылка', $activeLinks[0]->title);
    }

    /**
     * Тест фильтра неактивных ссылок
     */
    public function testInactiveFilter()
    {
        // Создаем активную ссылку
        $activeLink = new ReferralLink();
        $activeLink->title = 'Активная ссылка';
        $activeLink->url = 'https://example.com';
        $activeLink->status = ReferralLinkStatusEnum::STATUS_ACTIVE;
        $activeLink->save();

        // Создаем неактивную ссылку
        $inactiveLink = new ReferralLink();
        $inactiveLink->title = 'Неактивная ссылка';
        $inactiveLink->url = 'https://example2.com';
        $inactiveLink->status = ReferralLinkStatusEnum::STATUS_INACTIVE;
        $inactiveLink->save();

        $inactiveLinks = ReferralLink::find()->inactive()->all();

        $this->assertCount(1, $inactiveLinks);
        $this->assertEquals('Неактивная ссылка', $inactiveLinks[0]->title);
    }

    /**
     * Тест фильтра топовых ссылок
     */
    public function testTopFilter()
    {
        // Создаем обычную ссылку
        $regularLink = new ReferralLink();
        $regularLink->title = 'Обычная ссылка';
        $regularLink->url = 'https://example.com';
        $regularLink->is_top = false;
        $regularLink->save();

        // Создаем топовую ссылку
        $topLink = new ReferralLink();
        $topLink->title = 'Топовая ссылка';
        $topLink->url = 'https://example2.com';
        $topLink->is_top = true;
        $topLink->save();

        $topLinks = ReferralLink::find()->top()->all();

        $this->assertCount(1, $topLinks);
        $this->assertEquals('Топовая ссылка', $topLinks[0]->title);
    }

    /**
     * Тест фильтра обычных ссылок (не топовые)
     */
    public function testNotTopFilter()
    {
        // Создаем обычную ссылку
        $regularLink = new ReferralLink();
        $regularLink->title = 'Обычная ссылка';
        $regularLink->url = 'https://example.com';
        $regularLink->is_top = false;
        $regularLink->save();

        // Создаем топовую ссылку
        $topLink = new ReferralLink();
        $topLink->title = 'Топовая ссылка';
        $topLink->url = 'https://example2.com';
        $topLink->is_top = true;
        $topLink->save();

        $regularLinks = ReferralLink::find()->notTop()->all();

        $this->assertCount(1, $regularLinks);
        $this->assertEquals('Обычная ссылка', $regularLinks[0]->title);
    }

    /**
     * Тест сортировки по топовым ссылкам и приоритету
     */
    public function testByTopAndPrioritySort()
    {
        // Создаем обычную ссылку с высоким приоритетом
        $regularHighPriority = new ReferralLink();
        $regularHighPriority->title = 'Обычная с высоким приоритетом';
        $regularHighPriority->url = 'https://example.com';
        $regularHighPriority->is_top = false;
        $regularHighPriority->prior = 10;
        $regularHighPriority->save();

        // Создаем топовую ссылку с низким приоритетом
        $topLowPriority = new ReferralLink();
        $topLowPriority->title = 'Топовая с низким приоритетом';
        $topLowPriority->url = 'https://example2.com';
        $topLowPriority->is_top = true;
        $topLowPriority->prior = 5;
        $topLowPriority->save();

        // Создаем топовую ссылку с высоким приоритетом
        $topHighPriority = new ReferralLink();
        $topHighPriority->title = 'Топовая с высоким приоритетом';
        $topHighPriority->url = 'https://example3.com';
        $topHighPriority->is_top = true;
        $topHighPriority->prior = 15;
        $topHighPriority->save();

        $links = ReferralLink::find()->byTopAndPriority()->all();

        $this->assertCount(3, $links);
        // Первая должна быть топовая с высоким приоритетом
        $this->assertEquals('Топовая с высоким приоритетом', $links[0]->title);
        // Вторая должна быть топовая с низким приоритетом
        $this->assertEquals('Топовая с низким приоритетом', $links[1]->title);
        // Третья должна быть обычная с высоким приоритетом
        $this->assertEquals('Обычная с высоким приоритетом', $links[2]->title);
    }

    /**
     * Тест сортировки по приоритету
     */
    public function testByPrioritySort()
    {
        // Создаем ссылку с низким приоритетом
        $lowPriority = new ReferralLink();
        $lowPriority->title = 'Низкий приоритет';
        $lowPriority->url = 'https://example.com';
        $lowPriority->prior = 5;
        $lowPriority->save();

        // Создаем ссылку с высоким приоритетом
        $highPriority = new ReferralLink();
        $highPriority->title = 'Высокий приоритет';
        $highPriority->url = 'https://example2.com';
        $highPriority->prior = 15;
        $highPriority->save();

        // Создаем ссылку со средним приоритетом
        $mediumPriority = new ReferralLink();
        $mediumPriority->title = 'Средний приоритет';
        $mediumPriority->url = 'https://example3.com';
        $mediumPriority->prior = 10;
        $mediumPriority->save();

        $links = ReferralLink::find()->byPriority()->all();

        $this->assertCount(3, $links);
        // Первая должна быть с высоким приоритетом
        $this->assertEquals('Высокий приоритет', $links[0]->title);
        // Вторая должна быть со средним приоритетом
        $this->assertEquals('Средний приоритет', $links[1]->title);
        // Третья должна быть с низким приоритетом
        $this->assertEquals('Низкий приоритет', $links[2]->title);
    }

    /**
     * Тест сортировки по дате создания (новые сначала)
     */
    public function testLatestSort()
    {
        // Создаем старую ссылку
        $oldLink = new ReferralLink();
        $oldLink->title = 'Старая ссылка';
        $oldLink->url = 'https://example.com';
        $oldLink->save(false);
        $oldLink->updateAttributes(['created_at' => time() - 3600]);

        // Создаем новую ссылку
        $newLink = new ReferralLink();
        $newLink->title = 'Новая ссылка';
        $newLink->url = 'https://example2.com';
        $newLink->save(false);
        $newLink->updateAttributes(['created_at' => time()]);

        $links = ReferralLink::find()->latest()->all();

        $this->assertCount(2, $links);
        // Первая должна быть новая
        $this->assertEquals('Новая ссылка', $links[0]->title);
        // Вторая должна быть старая
        $this->assertEquals('Старая ссылка', $links[1]->title);
    }

    /**
     * Тест сортировки по дате создания (старые сначала)
     */
    public function testOldestSort()
    {
        // Создаем старую ссылку
        $oldLink = new ReferralLink();
        $oldLink->title = 'Старая ссылка';
        $oldLink->url = 'https://example.com';
        $oldLink->save(false);
        $oldLink->updateAttributes(['created_at' => time() - 3600]);

        // Создаем новую ссылку
        $newLink = new ReferralLink();
        $newLink->title = 'Новая ссылка';
        $newLink->url = 'https://example2.com';
        $newLink->save(false);
        $newLink->updateAttributes(['created_at' => time()]);

        $links = ReferralLink::find()->oldest()->all();

        $this->assertCount(2, $links);
        // Первая должна быть старая
        $this->assertEquals('Старая ссылка', $links[0]->title);
        // Вторая должна быть новая
        $this->assertEquals('Новая ссылка', $links[1]->title);
    }

    /**
     * Тест фильтра по названию
     */
    public function testByTitleFilter()
    {
        // Создаем ссылку с названием "Тестовая ссылка"
        $testLink = new ReferralLink();
        $testLink->title = 'Тестовая ссылка';
        $testLink->url = 'https://example.com';
        $testLink->save();

        // Создаем ссылку с названием "Другая ссылка"
        $otherLink = new ReferralLink();
        $otherLink->title = 'Другая ссылка';
        $otherLink->url = 'https://example2.com';
        $otherLink->save();

        $links = ReferralLink::find()->byTitle('Тестовая')->all();

        $this->assertCount(1, $links);
        $this->assertEquals('Тестовая ссылка', $links[0]->title);
    }
} 