<?php

declare(strict_types = 1);

namespace common\widgets;

use yii\base\Widget;
use common\components\BannerManager;

/**
 * Виджет для отображения баннеров
 */
class BannersWidget extends Widget
{
    /**
     * Позиция баннеров
     *
     * @var string
     */
    public string $position = 'left';

    /**
     * CSS класс контейнера
     *
     * @var string
     */
    public string $containerClass = 'd-flex flex-column align-items-center gap-4';

    /**
     * CSS класс баннера
     *
     * @var string
     */
    public string $bannerClass = 'border rounded p-1 w-100 text-center bg-light';

    /**
     * CSS класс изображения
     *
     * @var string
     */
    public string $imageClass = 'img-fluid';

    /**
     * Показывать ли баннеры
     *
     * @var boolean
     */
    public bool $showBanners = true;

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();
        
        // Проверяем глобальную настройку показа баннеров
        if ($this->showBanners) {
            $this->showBanners = \Yii::$app->params['showBanners'] ?? true;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function run(): string
    {
        if (!$this->showBanners || !BannerManager::hasBanners($this->position)) {
            return '';
        }

        $options = [
            'containerClass' => $this->containerClass,
            'bannerClass' => $this->bannerClass,
            'imageClass' => $this->imageClass,
        ];

        return BannerManager::renderBanners($this->position, $options);
    }
} 