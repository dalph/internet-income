<?php

declare(strict_types = 1);

namespace common\components;

use Yii;

/**
 * Менеджер баннеров
 */
class BannerManager
{
    /**
     * Получить баннеры для указанной позиции
     *
     * @param string $position
     * @return array
     */
    public static function getBanners(string $position): array
    {
        $banners = Yii::$app->params['banners'][$position] ?? [];
        
        return array_filter($banners, function ($banner) {
            return $banner['active'] ?? false;
        });
    }

    /**
     * Получить HTML для баннеров
     *
     * @param string $position
     * @param array $options
     * @return string
     */
    public static function renderBanners(string $position, array $options = []): string
    {
        $banners = self::getBanners($position);
        
        if (empty($banners)) {
            return '';
        }

        $containerClass = $options['containerClass'] ?? 'd-flex flex-column align-items-center gap-4';
        $bannerClass = $options['bannerClass'] ?? 'border rounded p-1 w-100 text-center bg-light';
        $imageClass = $options['imageClass'] ?? 'img-fluid';

        $html = '<div class="' . $containerClass . '">';
        
        foreach ($banners as $banner) {
            $html .= self::renderBanner($banner, $bannerClass, $imageClass);
        }
        
        $html .= '</div>';
        
        return $html;
    }

    /**
     * Рендерить один баннер
     *
     * @param array $banner
     * @param string $bannerClass
     * @param string $imageClass
     * @return string
     */
    private static function renderBanner(array $banner, string $bannerClass, string $imageClass): string
    {
        $html = '<div class="' . $bannerClass . '">';
        
        if (!empty($banner['url'])) {
            $html .= '<a href="' . htmlspecialchars($banner['url']) . '" target="_blank">';
        }
        
        $html .= '<img src="' . htmlspecialchars($banner['src']) . '" ';
        $html .= 'alt="' . htmlspecialchars($banner['alt']) . '" ';
        $html .= 'title="' . htmlspecialchars($banner['title']) . '" ';
        $html .= 'class="' . $imageClass . '">';
        
        if (!empty($banner['url'])) {
            $html .= '</a>';
        }
        
        $html .= '</div>';
        
        return $html;
    }

    /**
     * Проверить, есть ли баннеры для позиции
     *
     * @param string $position
     * @return boolean
     */
    public static function hasBanners(string $position): bool
    {
        return !empty(self::getBanners($position));
    }

    /**
     * Получить количество баннеров для позиции
     *
     * @param string $position
     * @return integer
     */
    public static function getBannerCount(string $position): int
    {
        return count(self::getBanners($position));
    }
} 