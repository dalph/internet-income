<?php

declare(strict_types = 1);

namespace common\tests\unit\components;

use common\components\BannerManager;
use common\tests\_support\BaseUnit;
use Yii;

/**
 * Тест для BannerManager
 */
class BannerManagerTest extends BaseUnit
{
    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Устанавливаем тестовые параметры
        Yii::$app->params['banners'] = [
            'left' => [
                [
                    'src' => '/img/test.jpg',
                    'alt' => 'Test Banner',
                    'title' => 'Test',
                    'url' => 'https://test.com',
                    'active' => true,
                ],
                [
                    'src' => '/img/inactive.jpg',
                    'alt' => 'Inactive Banner',
                    'title' => 'Inactive',
                    'url' => '',
                    'active' => false,
                ],
            ],
            'right' => [],
        ];
    }

    /**
     * Тест получения баннеров
     */
    public function testGetBanners(): void
    {
        $banners = BannerManager::getBanners('left');
        
        $this->assertCount(1, $banners);
        $this->assertEquals('/img/test.jpg', $banners[0]['src']);
    }

    /**
     * Тест получения пустых баннеров
     */
    public function testGetEmptyBanners(): void
    {
        $banners = BannerManager::getBanners('right');
        
        $this->assertEmpty($banners);
    }

    /**
     * Тест проверки наличия баннеров
     */
    public function testHasBanners(): void
    {
        $this->assertTrue(BannerManager::hasBanners('left'));
        $this->assertFalse(BannerManager::hasBanners('right'));
    }

    /**
     * Тест подсчета баннеров
     */
    public function testGetBannerCount(): void
    {
        $this->assertEquals(1, BannerManager::getBannerCount('left'));
        $this->assertEquals(0, BannerManager::getBannerCount('right'));
    }

    /**
     * Тест рендеринга баннеров
     */
    public function testRenderBanners(): void
    {
        $html = BannerManager::renderBanners('left');
        
        $this->assertStringContainsString('/img/test.jpg', $html);
        $this->assertStringContainsString('/img/test.jpg', $html);
        $this->assertStringContainsString('Test Banner', $html);
        $this->assertStringContainsString('https://test.com', $html);
    }

    /**
     * Тест рендеринга пустых баннеров
     */
    public function testRenderEmptyBanners(): void
    {
        $html = BannerManager::renderBanners('right');
        
        $this->assertEmpty($html);
    }

    /**
     * Тест рендеринга баннера без URL
     */
    public function testRenderBannerWithoutUrl(): void
    {
        // Устанавливаем баннер без URL
        Yii::$app->params['banners']['left'][0]['url'] = '';
        
        $html = BannerManager::renderBanners('left');
        
        $this->assertStringNotContainsString('<a href', $html);
        $this->assertStringContainsString('<img', $html);
    }
} 