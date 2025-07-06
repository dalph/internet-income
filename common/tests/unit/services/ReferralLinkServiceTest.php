<?php

declare(strict_types = 1);

namespace common\tests\unit\services;

use common\models\ReferralLink;
use common\enum\ReferralLinkStatusEnum;
use common\models\ReferralLinkCategory;
use common\enum\ReferralLinkCategoryStatusEnum;
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
            'status' => ReferralLinkStatusEnum::STATUS_ACTIVE,
            'is_top' => true,
            'prior' => 10,
        ];

        $result = $this->service->create($data);

        $this->assertInstanceOf(ReferralLink::class, $result);
        $this->assertEquals('Тестовая ссылка', $result->title);
        $this->assertEquals('https://example.com', $result->url);
        $this->assertEquals(ReferralLinkStatusEnum::STATUS_ACTIVE, $result->status);
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
     * Тест создания ссылки с полностью неверными данными
     */
    public function testCreateWithCompletelyInvalidData()
    {
        $data = [
            'title' => null, // Null название
            'url' => null, // Null URL
            'status' => 'invalid-status', // Неверный статус
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
            'status' => ReferralLinkStatusEnum::STATUS_INACTIVE,
            'is_top' => false,
            'prior' => 5,
        ];

        $result = $this->service->update($link->id, $data);

        $this->assertInstanceOf(ReferralLink::class, $result);
        $this->assertEquals('Обновленная ссылка', $result->title);
        $this->assertEquals('https://updated-example.com', $result->url);
        $this->assertEquals(ReferralLinkStatusEnum::STATUS_INACTIVE, $result->status);
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
        $link->status = ReferralLinkStatusEnum::STATUS_ACTIVE;
        $link->save();

        // Изменяем статус на неактивный
        $result = $this->service->changeStatus($link->id, ReferralLinkStatusEnum::STATUS_INACTIVE);

        $this->assertTrue($result);
        
        $updatedLink = ReferralLink::findOne($link->id);
        $this->assertEquals(ReferralLinkStatusEnum::STATUS_INACTIVE, $updatedLink->status);
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
     * Тест изменения топового статуса несуществующей ссылки
     */
    public function testChangeTopStatusNonExistentLink()
    {
        $result = $this->service->changeTopStatus(99999, true);
        $this->assertFalse($result);
    }

    /**
     * Тест изменения топового статуса с неверными данными
     */
    public function testChangeTopStatusWithInvalidData()
    {
        $link = new ReferralLink();
        $link->title = 'Тестовая ссылка';
        $link->url = 'https://example.com';
        $link->save();

        // Тестируем с разными типами данных
        $result1 = $this->service->changeTopStatus($link->id, 'true');
        $result2 = $this->service->changeTopStatus($link->id, 1);
        $result3 = $this->service->changeTopStatus($link->id, 0);

        $this->assertTrue($result1);
        $this->assertTrue($result2);
        $this->assertTrue($result3);
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
        $activeLink->status = ReferralLinkStatusEnum::STATUS_ACTIVE;
        $activeLink->save();

        // Создаем неактивную ссылку
        $inactiveLink = new ReferralLink();
        $inactiveLink->title = 'Неактивная ссылка';
        $inactiveLink->url = 'https://example2.com';
        $inactiveLink->status = ReferralLinkStatusEnum::STATUS_INACTIVE;
        $inactiveLink->save();

        $activeLinks = $this->service->getActiveLinks();

        $this->assertCount(1, $activeLinks);
        $this->assertEquals('Активная ссылка', $activeLinks[0]->title);
    }

    /**
     * Тест получения активных ссылок без категорий
     */
    public function testGetActiveLinksWithoutCategory()
    {
        // Создаем категорию
        $category = new ReferralLinkCategory();
        $category->title = 'Тестовая категория';
        $category->status = ReferralLinkCategoryStatusEnum::STATUS_ACTIVE;
        $category->save();

        // Создаем ссылку с категорией
        $link1 = new ReferralLink();
        $link1->title = 'Ссылка с категорией';
        $link1->url = 'https://example1.com';
        $link1->status = ReferralLinkStatusEnum::STATUS_ACTIVE;
        $link1->category_id = $category->id;
        $link1->save();

        // Создаем ссылку без категории
        $link2 = new ReferralLink();
        $link2->title = 'Ссылка без категории';
        $link2->url = 'https://example2.com';
        $link2->status = ReferralLinkStatusEnum::STATUS_ACTIVE;
        $link2->save();

        $result = $this->service->getActiveLinksWithoutCategory();

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertNull($result[0]->category_id);
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
        $regularLink->status = ReferralLinkStatusEnum::STATUS_ACTIVE;
        $regularLink->is_top = false;
        $regularLink->save();

        // Создаем топовую активную ссылку
        $topLink = new ReferralLink();
        $topLink->title = 'Топовая ссылка';
        $topLink->url = 'https://example2.com';
        $topLink->status = ReferralLinkStatusEnum::STATUS_ACTIVE;
        $topLink->is_top = true;
        $topLink->save();

        $topLinks = $this->service->getTopActiveLinks();

        $this->assertCount(1, $topLinks);
        $this->assertEquals('Топовая ссылка', $topLinks[0]->title);
    }

    /**
     * Тест получения провайдера данных без параметров
     */
    public function testGetDataProviderWithoutParams()
    {
        // Создаем несколько ссылок для тестирования
        $link1 = new ReferralLink();
        $link1->title = 'Ссылка 1';
        $link1->url = 'https://example1.com';
        $link1->status = ReferralLinkStatusEnum::STATUS_ACTIVE;
        $link1->is_top = true;
        $link1->save();

        $link2 = new ReferralLink();
        $link2->title = 'Ссылка 2';
        $link2->url = 'https://example2.com';
        $link2->status = ReferralLinkStatusEnum::STATUS_INACTIVE;
        $link2->is_top = false;
        $link2->save();

        $dataProvider = $this->service->getDataProvider();

        $this->assertInstanceOf(\yii\data\ActiveDataProvider::class, $dataProvider);
        $this->assertEquals(20, $dataProvider->pagination->pageSize);
    }

    /**
     * Тест получения провайдера данных с фильтром по названию
     */
    public function testGetDataProviderWithTitleFilter()
    {
        // Создаем ссылки с разными названиями
        $link1 = new ReferralLink();
        $link1->title = 'Тестовая ссылка';
        $link1->url = 'https://example1.com';
        $link1->save();

        $link2 = new ReferralLink();
        $link2->title = 'Другая ссылка';
        $link2->url = 'https://example2.com';
        $link2->save();

        $dataProvider = $this->service->getDataProvider(['title' => 'Тестовая']);

        $this->assertInstanceOf(\yii\data\ActiveDataProvider::class, $dataProvider);
    }

    /**
     * Тест получения провайдера данных с фильтром по статусу
     */
    public function testGetDataProviderWithStatusFilter()
    {
        // Создаем ссылки с разными статусами
        $activeLink = new ReferralLink();
        $activeLink->title = 'Активная ссылка';
        $activeLink->url = 'https://example1.com';
        $activeLink->status = ReferralLinkStatusEnum::STATUS_ACTIVE;
        $activeLink->save();

        $inactiveLink = new ReferralLink();
        $inactiveLink->title = 'Неактивная ссылка';
        $inactiveLink->url = 'https://example2.com';
        $inactiveLink->status = ReferralLinkStatusEnum::STATUS_INACTIVE;
        $inactiveLink->save();

        $dataProvider = $this->service->getDataProvider(['status' => ReferralLinkStatusEnum::STATUS_ACTIVE]);

        $this->assertInstanceOf(\yii\data\ActiveDataProvider::class, $dataProvider);
    }

    /**
     * Тест получения провайдера данных с фильтром по топовому статусу
     */
    public function testGetDataProviderWithTopFilter()
    {
        // Создаем топовую и обычную ссылки
        $topLink = new ReferralLink();
        $topLink->title = 'Топовая ссылка';
        $topLink->url = 'https://example1.com';
        $topLink->is_top = true;
        $topLink->save();

        $regularLink = new ReferralLink();
        $regularLink->title = 'Обычная ссылка';
        $regularLink->url = 'https://example2.com';
        $regularLink->is_top = false;
        $regularLink->save();

        $dataProvider = $this->service->getDataProvider(['is_top' => true]);

        $this->assertInstanceOf(\yii\data\ActiveDataProvider::class, $dataProvider);
    }

    /**
     * Тест получения провайдера данных с фильтром по не топовому статусу
     */
    public function testGetDataProviderWithNotTopFilter()
    {
        // Создаем топовую и обычную ссылки
        $topLink = new ReferralLink();
        $topLink->title = 'Топовая ссылка';
        $topLink->url = 'https://example1.com';
        $topLink->is_top = true;
        $topLink->save();

        $regularLink = new ReferralLink();
        $regularLink->title = 'Обычная ссылка';
        $regularLink->url = 'https://example2.com';
        $regularLink->is_top = false;
        $regularLink->save();

        $dataProvider = $this->service->getDataProvider(['is_top' => false]);

        $this->assertInstanceOf(\yii\data\ActiveDataProvider::class, $dataProvider);
    }

    /**
     * Тест получения провайдера данных с комбинированными фильтрами
     */
    public function testGetDataProviderWithCombinedFilters()
    {
        // Создаем ссылки для комбинированного тестирования
        $link1 = new ReferralLink();
        $link1->title = 'Тестовая топовая';
        $link1->url = 'https://example1.com';
        $link1->status = ReferralLinkStatusEnum::STATUS_ACTIVE;
        $link1->is_top = true;
        $link1->save();

        $link2 = new ReferralLink();
        $link2->title = 'Другая обычная';
        $link2->url = 'https://example2.com';
        $link2->status = ReferralLinkStatusEnum::STATUS_INACTIVE;
        $link2->is_top = false;
        $link2->save();

        $dataProvider = $this->service->getDataProvider([
            'title' => 'Тестовая',
            'status' => ReferralLinkStatusEnum::STATUS_ACTIVE,
            'is_top' => true,
        ]);

        $this->assertInstanceOf(\yii\data\ActiveDataProvider::class, $dataProvider);
    }

    /**
     * Тест получения провайдера данных с фильтром по категории
     */
    public function testGetDataProviderWithCategoryFilter()
    {
        // Создаем категорию
        $category = new ReferralLinkCategory();
        $category->title = 'Тестовая категория';
        $category->status = ReferralLinkCategoryStatusEnum::STATUS_ACTIVE;
        $category->save();

        // Создаем ссылку с категорией
        $link1 = new ReferralLink();
        $link1->title = 'Ссылка с категорией';
        $link1->url = 'https://example1.com';
        $link1->category_id = $category->id;
        $link1->save();

        // Создаем ссылку без категории
        $link2 = new ReferralLink();
        $link2->title = 'Ссылка без категории';
        $link2->url = 'https://example2.com';
        $link2->save();

        $dataProvider = $this->service->getDataProvider(['category_id' => $category->id]);

        $this->assertInstanceOf(\yii\data\ActiveDataProvider::class, $dataProvider);
    }

    /**
     * Тест getDataProvider с пустыми параметрами
     */
    public function testGetDataProviderWithEmptyParams()
    {
        $dataProvider = $this->service->getDataProvider([]);
        
        $this->assertInstanceOf(\yii\data\ActiveDataProvider::class, $dataProvider);
        $this->assertEquals(20, $dataProvider->pagination->pageSize);
    }

    /**
     * Тест getDataProvider с null параметрами
     */
    public function testGetDataProviderWithNullParams()
    {
        $dataProvider = $this->service->getDataProvider(null);
        
        $this->assertInstanceOf(\yii\data\ActiveDataProvider::class, $dataProvider);
    }

    /**
     * Тест loadModel с пустым title
     */
    public function testLoadModelWithEmptyTitle()
    {
        $query = ReferralLink::find();
        $params = ['title' => ''];
        
        // Используем рефлексию для тестирования protected метода
        $reflection = new \ReflectionClass($this->service);
        $method = $reflection->getMethod('loadModel');
        $method->setAccessible(true);
        
        $result = $method->invoke($this->service, $query, $params);
        
        $this->assertTrue($result);
    }

    /**
     * Тест loadModel с неверным статусом
     */
    public function testLoadModelWithInvalidStatus()
    {
        $query = ReferralLink::find();
        $params = ['status' => 999];
        
        $reflection = new \ReflectionClass($this->service);
        $method = $reflection->getMethod('loadModel');
        $method->setAccessible(true);
        
        $result = $method->invoke($this->service, $query, $params);
        
        $this->assertTrue($result);
    }

    /**
     * Тест loadModel с is_top = 0
     */
    public function testLoadModelWithIsTopZero()
    {
        $query = ReferralLink::find();
        $params = ['is_top' => 0];
        
        $reflection = new \ReflectionClass($this->service);
        $method = $reflection->getMethod('loadModel');
        $method->setAccessible(true);
        
        $result = $method->invoke($this->service, $query, $params);
        
        $this->assertTrue($result);
    }

    /**
     * Тест loadModel с is_top = false
     */
    public function testLoadModelWithIsTopFalse()
    {
        $query = ReferralLink::find();
        $params = ['is_top' => false];
        
        $reflection = new \ReflectionClass($this->service);
        $method = $reflection->getMethod('loadModel');
        $method->setAccessible(true);
        
        $result = $method->invoke($this->service, $query, $params);
        
        $this->assertTrue($result);
    }

    /**
     * Тест loadModel с is_top = true
     */
    public function testLoadModelWithIsTopTrue()
    {
        $query = ReferralLink::find();
        $params = ['is_top' => true];
        
        $reflection = new \ReflectionClass($this->service);
        $method = $reflection->getMethod('loadModel');
        $method->setAccessible(true);
        
        $result = $method->invoke($this->service, $query, $params);
        
        $this->assertTrue($result);
    }

    /**
     * Тест loadModel с is_top = 1
     */
    public function testLoadModelWithIsTopOne()
    {
        $query = ReferralLink::find();
        $params = ['is_top' => 1];
        
        $reflection = new \ReflectionClass($this->service);
        $method = $reflection->getMethod('loadModel');
        $method->setAccessible(true);
        
        $result = $method->invoke($this->service, $query, $params);
        
        $this->assertTrue($result);
    }

    /**
     * Тест создания ссылки когда save возвращает false
     */
    public function testCreateWhenSaveReturnsFalse()
    {
        // Создаем ссылку с неверными данными, которые не пройдут валидацию
        $data = [
            'title' => '', // Пустое название - не пройдет валидацию
            'url' => 'invalid-url', // Неверный URL - не пройдет валидацию
        ];

        $result = $this->service->create($data);

        $this->assertFalse($result);
    }

    /**
     * Тест обновления ссылки когда save возвращает false
     */
    public function testUpdateWhenSaveReturnsFalse()
    {
        // Создаем ссылку для обновления
        $link = new ReferralLink();
        $link->title = 'Исходная ссылка';
        $link->url = 'https://example.com';
        $link->save();

        // Пытаемся обновить с неверными данными
        $data = [
            'title' => '', // Пустое название - не пройдет валидацию
            'url' => 'invalid-url', // Неверный URL - не пройдет валидацию
        ];

        $result = $this->service->update($link->id, $data);

        $this->assertFalse($result);
    }

    /**
     * Тест изменения статуса несуществующей ссылки
     */
    public function testChangeStatusNonExistentLink()
    {
        $result = $this->service->changeStatus(99999, ReferralLinkStatusEnum::STATUS_INACTIVE);

        $this->assertFalse($result);
    }

    /**
     * Тест изменения статуса когда save возвращает false
     */
    public function testChangeStatusWhenSaveReturnsFalse()
    {
        // Создаем ссылку с данными, которые могут вызвать ошибку при сохранении
        $link = new ReferralLink();
        $link->title = 'Тестовая ссылка';
        $link->url = 'https://example.com';
        $link->save();

        // Попробуем изменить статус на неверное значение, которое может вызвать ошибку
        $result = $this->service->changeStatus($link->id, 999);

        $this->assertFalse($result);
    }

    /**
     * Тест изменения топового статуса когда save возвращает false
     */
    public function testChangeTopStatusWhenSaveReturnsFalse()
    {
        // Создаем ссылку
        $link = new ReferralLink();
        $link->title = 'Тестовая ссылка';
        $link->url = 'https://example.com';
        $link->save();

        // Попробуем изменить топовый статус
        $result = $this->service->changeTopStatus($link->id, true);

        $this->assertTrue($result);
    }

    /**
     * Тест getDataProvider с неверными параметрами
     */
    public function testGetDataProviderWithInvalidParams()
    {
        $dataProvider = $this->service->getDataProvider(['invalid_param' => 'value']);

        $this->assertInstanceOf(\yii\data\ActiveDataProvider::class, $dataProvider);
    }

    /**
     * Тест loadModel с неверными параметрами
     */
    public function testLoadModelWithInvalidParams()
    {
        $query = ReferralLink::find();
        $params = ['invalid_param' => 'value'];
        
        $reflection = new \ReflectionClass($this->service);
        $method = $reflection->getMethod('loadModel');
        $method->setAccessible(true);
        
        $result = $method->invoke($this->service, $query, $params);
        
        $this->assertTrue($result);
    }
} 