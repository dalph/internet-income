# Internet Income - Docker Environment

Docker окружение для разработки с PHP 8.3, MySQL 8.0 и Nginx.

## Компоненты

- **PHP 8.3** - с расширениями для работы с MySQL, GD, ZIP и другими
- **MySQL 8.0** - база данных
- **Nginx** - веб-сервер
- **Composer** - менеджер зависимостей PHP

## Быстрый старт

1. Клонируйте репозиторий
2. Запустите контейнеры:
   ```bash
   make up
   ```
3. Откройте браузер: http://localhost

## Команды Makefile

- `make start` - быстрый запуск (сборка + запуск)
- `make up` - запуск контейнеров
- `make down` - остановка контейнеров
- `make build` - сборка контейнеров
- `make restart` - перезапуск контейнеров
- `make restart-full` - полный перезапуск (остановка + запуск)
- `make logs` - просмотр логов
- `make shell` - вход в контейнер PHP
- `make composer cmd="install"` - выполнение composer команд
- `make php cmd="--version"` - выполнение PHP команд

## Настройки базы данных

- **Хост**: db
- **Порт**: 3306
- **База данных**: internet_income
- **Пользователь**: internet_income
- **Пароль**: password
- **Root пароль**: root

## Структура проекта

```
├── docker/
│   ├── mysql/
│   │   └── my.cnf
│   ├── nginx/
│   │   └── conf.d/
│   │       └── app.conf
│   └── php/
│       ├── Dockerfile
│       └── local.ini
├── public/
│   └── index.php
├── docker-compose.yml
├── Makefile
└── README.md
``` 