<?php

declare(strict_types = 1);

namespace common\config;

/**
 * Класс для загрузки конфигурации приложения
 */
class ConfigLoader
{
    /**
     * Базовый путь к проекту
     */
    private string $basePath;

    /**
     * Тип приложения
     */
    private string $appType;

    /**
     * Конструктор
     *
     * @param string $basePath
     * @param string $appType
     */
    public function __construct(string $basePath, string $appType)
    {
        $this->basePath = $basePath;
        $this->appType = $appType;
    }

    /**
     * Загружает конфигурацию приложения
     *
     * @return array
     */
    public function load(): array
    {
        $configs = [
            $this->basePath . '/common/config/main.php',
            $this->basePath . '/common/config/main-local.php',
            $this->basePath . '/' . $this->appType . '/config/main.php',
            $this->basePath . '/' . $this->appType . '/config/main-local.php',
        ];

        $mergedConfig = [];
        
        foreach ($configs as $configFile) {
            if (file_exists($configFile)) {
                $config = require $configFile;
                $mergedConfig = \yii\helpers\ArrayHelper::merge($mergedConfig, $config);
            }
        }

        return $mergedConfig;
    }

    /**
     * Подключает bootstrap файл приложения
     *
     * @return void
     */
    public function loadBootstrap(): void
    {
        $bootstrapFile = $this->basePath . '/' . $this->appType . '/config/bootstrap.php';
        
        if (file_exists($bootstrapFile)) {
            require $bootstrapFile;
        }
    }
} 