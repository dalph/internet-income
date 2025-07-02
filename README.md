# Internet Income - Система управления интернет-доходами

[![codecov](https://codecov.io/gh/dalph/internet-income/branch/master/graph/badge.svg)](https://codecov.io/gh/dalph/internet-income)

Проект построен на базе Yii2 расширенного шаблона с разделением на frontend и backend.

## Структура проекта

- `frontend/` - Публичная часть сайта (домен: mii.local)
- `backend/` - Панель администратора (домен: admin.mii.local)
- `common/` - Общие компоненты и модели
- `console/` - Консольные команды
- `docker/` - Docker конфигурация

## Требования

- Docker
- Docker Compose
- Traefik (для роутинга доменов)

## Установка и запуск

1. Клонируйте репозиторий:
```bash
git clone <repository-url>
cd internet-dohod
```

2. Запустите проект:
```bash
docker-compose -f docker-compose.yml up -d
```

3. Инициализируйте Yii2 приложение:
```bash
docker-compose -f docker-compose.yml exec app php /var/www/init --env=Development --overwrite=All
```

4. Запустите миграции:
```bash
docker-compose -f docker-compose.yml exec app php /var/www/yii migrate --interactive=0
```

## Доступ к приложению

- **Frontend**: https://mii.local
- **Backend**: https://admin.mii.local

## База данных

- **Хост**: localhost:3306
- **База данных**: internet_income
- **Пользователь**: internet_income
- **Пароль**: password

## Полезные команды

### Установка зависимостей
```bash
docker-compose -f docker-compose.yml exec app composer install
```

### Запуск консольных команд
```bash
docker-compose -f docker-compose.yml exec app php /var/www/yii <command>
```

### Просмотр логов
```bash
docker-compose -f docker-compose.yml logs -f
```

## Разработка

### Структура приложения

Проект использует расширенный шаблон Yii2 с разделением на:

- **Frontend** - публичная часть для пользователей
- **Backend** - административная панель
- **Common** - общие модели и компоненты
- **Console** - консольные команды

### Конфигурация

Основные конфигурационные файлы:
- `common/config/main-local.php` - общие настройки
- `frontend/config/main-local.php` - настройки frontend
- `backend/config/main-local.php` - настройки backend

### База данных

Для работы с базой данных используются миграции:
```bash
# Создание новой миграции
docker-compose -f docker-compose.yml exec app php /var/www/yii migrate/create <migration_name>

# Запуск миграций
docker-compose -f docker-compose.yml exec app php /var/www/yii migrate --interactive=0
```

## Лицензия

MIT License

## Покрытие кода тестами

Для локального анализа покрытия используйте:
```bash
make test-coverage
```

После выполнения команда сгенерирует отчёты:
- HTML: `common/tests/_output/coverage/index.html`
- XML: `common/tests/_output/coverage.xml`

Для настройки Codecov:
1. Перейдите на [codecov.io](https://codecov.io)
2. Подключите ваш GitHub репозиторий
3. Добавьте токен в секреты GitHub (CODECOV_TOKEN)
4. После этого можно будет добавить бейдж покрытия обратно в README