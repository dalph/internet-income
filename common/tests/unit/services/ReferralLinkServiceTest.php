<?php

declare(strict_types = 1);

namespace common\tests\unit\services;

use common\models\ReferralLink;
use common\models\ReferralLinkEnum;
use common\services\ReferralLinkService;
use common\tests\UnitTester;

/**
 * Тест для сервиса ReferralLinkService
 */
class ReferralLinkServiceTest extends \Codeception\Test\Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var ReferralLinkService
     */
    private $service;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ReferralLinkService();
    }

    /**
     * Тест создания реферальной ссылки
     */
    public function testCreate()
    {
        $data = [
            'title' => 'Тестовая ссылка',
            'url' => 'https://example.com',
            'description' => 'Описание тестовой ссылки',
            'status' => ReferralLinkEnum::STATUS_ACTIVE,
            'is_top' => true,
            'prior' => 10,
        ];

        $result = $this->service->create($data);

        $this->assertInstanceOf(ReferralLink::class, $result);
        $this->assertEquals('Тестовая ссылка', $result->title);
        $this->assertEquals('https://example.com', $result->url);
        $this->assertEquals(ReferralLinkEnum::STATUS_ACTIVE, $result->status);
        $this->assertTrue($result->is_top);
        $this->assertEquals(10, $result->prior);
    }

    /**
     * Тест создания реферальной ссылки с неверными данными
     */
    public function testCreateWithInvalidData()
    {
        $data = [
            'title' => '', // Пустое название
            'url' => 'invalid-url', // Неверный URL
        ];

        $result = $this->service->create($data);

        $this->assertFalse($result);
    }

    /**
     * Тест обновления реферальной ссылки
     */
    public function testUpdate()
    {
        // Создаем ссылку для обновления
        $link = new ReferralLink();
        $link->title = 'Исходная ссылка';
        $link->url = 'https://example.com';
        $link->save();

        $data = [
            'title' => 'Обновленная ссылка',
            'url' => 'https://updated-example.com',
            'description' => 'Обновленное описание',
            'status' => ReferralLinkEnum::STATUS_INACTIVE,
            'is_top' => false,
            'prior' => 5,
        ];

        $result = $this->service->update($link->id, $data);

        $this->assertInstanceOf(ReferralLink::class, $result);
        $this->assertEquals('Обновленная ссылка', $result->title);
        $this->assertEquals('https://updated-example.com', $result->url);
        $this->assertEquals(ReferralLinkEnum::STATUS_INACTIVE, $result->status);
        $this->assertFalse($result->is_top);
        $this->assertEquals(5, $result->prior);
    }

    /**
     * Тест обновления несуществующей ссылки
     */
    public function testUpdateNonExistentLink()
    {
        $data = [
            'title' => 'Обновленная ссылка',
            'url' => 'https://example.com',
        ];

        $result = $this->service->update(99999, $data);

        $this->assertFalse($result);
    }

    /**
     * Тест удаления реферальной ссылки
     */
    public function testDelete()
    {
        // Создаем ссылку для удаления
        $link = new ReferralLink();
        $link->title = 'Ссылка для удаления';
        $link->url = 'https://example.com';
        $link->save();

        $linkId = $link->id;

        $result = $this->service->delete($linkId);

        $this->assertTrue($result);
        $this->assertNull(ReferralLink::findOne($linkId));
    }

    /**
     * Тест удаления несуществующей ссылки
     */
    public function testDeleteNonExistentLink()
    {
        $result = $this->service->delete(99999);

        $this->assertFalse($result);
    }

    /**
     * Тест изменения статуса ссылки
     */
    public function testChangeStatus()
    {
        // Создаем активную ссылку
        $link = new ReferralLink();
        $link->title = 'Тестовая ссылка';
        $link->url = 'https://example.com';
        $link->status = ReferralLinkEnum::STATUS_ACTIVE;
        $link->save();

        // Изменяем статус на неактивный
        $result = $this->service->changeStatus($link->id, ReferralLinkEnum::STATUS_INACTIVE);

        $this->assertTrue($result);
        
        $updatedLink = ReferralLink::findOne($link->id);
        $this->assertEquals(ReferralLinkEnum::STATUS_INACTIVE, $updatedLink->status);
    }

    /**
     * Тест изменения статуса с неверным статусом
     */
    public function testChangeStatusWithInvalidStatus()
    {
        $link = new ReferralLink();
        $link->title = 'Тестовая ссылка';
        $link->url = 'https://example.com';
        $link->save();

        $result = $this->service->changeStatus($link->id, 999);

        $this->assertFalse($result);
    }

    /**
     * Тест изменения топового статуса
     */
    public function testChangeTopStatus()
    {
        // Создаем обычную ссылку
        $link = new ReferralLink();
        $link->title = 'Тестовая ссылка';
        $link->url = 'https://example.com';
        $link->is_top = false;
        $link->save();

        // Делаем ссылку топовой
        $result = $this->service->changeTopStatus($link->id, true);

        $this->assertTrue((bool) $result);
        
        $updatedLink = ReferralLink::findOne($link->id);
        $this->assertTrue((bool) $updatedLink->is_top);
    }

    /**
     * Тест получения активных ссылок
     */
    public function testGetActiveLinks()
    {
        // Создаем активную ссылку
        $activeLink = new ReferralLink();
        $activeLink->title = 'Активная ссылка';
        $activeLink->url = 'https://example.com';
        $activeLink->status = ReferralLinkEnum::STATUS_ACTIVE;
        $activeLink->save();

        // Создаем неактивную ссылку
        $inactiveLink = new ReferralLink();
        $inactiveLink->title = 'Неактивная ссылка';
        $inactiveLink->url = 'https://example2.com';
        $inactiveLink->status = ReferralLinkEnum::STATUS_INACTIVE;
        $inactiveLink->save();

        $activeLinks = $this->service->getActiveLinks();

        $this->assertCount(1, $activeLinks);
        $this->assertEquals('Активная ссылка', $activeLinks[0]->title);
    }

    /**
     * Тест получения топовых активных ссылок
     */
    public function testGetTopActiveLinks()
    {
        // Создаем обычную активную ссылку
        $regularLink = new ReferralLink();
        $regularLink->title = 'Обычная ссылка';
        $regularLink->url = 'https://example.com';
        $regularLink->status = ReferralLinkEnum::STATUS_ACTIVE;
        $regularLink->is_top = false;
        $regularLink->save();

        // Создаем топовую активную ссылку
        $topLink = new ReferralLink();
        $topLink->title = 'Топовая ссылка';
        $topLink->url = 'https://example2.com';
        $topLink->status = ReferralLinkEnum::STATUS_ACTIVE;
        $topLink->is_top = true;
        $topLink->save();

        $topLinks = $this->service->getTopActiveLinks();

        $this->assertCount(1, $topLinks);
        $this->assertEquals('Топовая ссылка', $topLinks[0]->title);
    }
} 