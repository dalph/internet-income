<?php

declare(strict_types = 1);

namespace console\controllers;

use yii\helpers\Console;

/**
 * Базовый контроллер для консольных команд
 */
class BaseController extends \yii\console\Controller
{
    /**
     * Выводит информационное сообщение
     */
    public function info(string $message, ?array $data = null): void
    {
        $this->stdout("[INFO] $message\n", Console::FG_GREEN);
        if (false === empty($data)) {
            $this->stdout(print_r($data, true), Console::FG_GREEN);
        }
    }

    /**
     * Выводит сообщение об ошибке
     */
    public function error(string $message, ?array $data = null): void
    {
        $this->stderr("[ERROR] $message\n", Console::FG_RED);
        if (false === empty($data)) {
            $this->stderr(print_r($data, true), Console::FG_RED);
        }
    }

    /**
     * Выводит предупреждение
     */
    public function warning(string $message, ?array $data = null): void
    {
        $this->stdout("[WARNING] $message\n", Console::FG_YELLOW);
        if (false === empty($data)) {
            $this->stdout(print_r($data, true), Console::FG_YELLOW);
        }
    }
} 