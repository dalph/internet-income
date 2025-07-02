# Покрытие кода тестами

## Локальный запуск тестов с покрытием

Для запуска тестов с анализом покрытия кода используйте команду:

```bash
make test-coverage
```

Эта команда:
1. Создает тестовую базу данных
2. Применяет миграции
3. Запускает unit тесты с анализом покрытия
4. Генерирует HTML и XML отчеты

## Просмотр отчетов

После выполнения команды `make test-coverage` отчеты будут доступны в:

- **HTML отчет**: `common/tests/_output/coverage/index.html`
- **XML отчет**: `common/tests/_output/coverage.xml`

Для просмотра HTML отчета откройте файл в браузере или используйте локальный сервер:

```bash
# В контейнере
docker-compose -f docker-compose.yml exec app php -S localhost:8000 -t common/tests/_output/coverage

# Или скопируйте файлы на хост
docker-compose -f docker-compose.yml cp app:/var/www/common/tests/_output/coverage ./coverage-reports
```

## Настройки покрытия

Покрытие настроено в файле `common/tests/unit.suite.yml`:

- **Включенные директории**: `common/models/*`, `common/services/*`
- **Исключенные директории**: `common/tests/*`, `common/config/*`, `common/mail/*`, `common/widgets/*`
- **Минимальное покрытие**: 70%
- **Целевое покрытие**: 90%

## GitHub Actions

При каждом push в ветки `master`, а также при создании Pull Request в ветку `master` автоматически:

1. Запускаются тесты с покрытием
2. Результаты загружаются в Codecov
3. Отображается бейдж с процентом покрытия

## Полезные команды

```bash
# Запуск только тестов без покрытия
make test

# Запуск тестов с покрытием
make test-coverage

# Запуск конкретного теста
docker-compose -f docker-compose.yml exec app vendor/bin/codecept run unit models/ReferralLinkTest -c common

# Просмотр доступных команд Codeception
docker-compose -f docker-compose.yml exec app vendor/bin/codecept --help
``` 