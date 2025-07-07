.PHONY: up down build restart logs shell composer start cache-clear cache-schema cache-assets cache-all runtime-clear clean

# Запуск контейнеров
up:
	docker-compose -f docker-compose.yml up -d

# Быстрый запуск (сборка + запуск)
start:
	docker-compose -f docker-compose.yml up -d --build

# Остановка контейнеров
down:
	docker-compose -f docker-compose.yml down

# Сборка контейнеров
build:
	docker-compose -f docker-compose.yml build

# Перезапуск контейнеров
restart:
	docker-compose -f docker-compose.yml down
	docker-compose -f docker-compose.yml up -d

# Просмотр логов
logs:
	docker-compose -f docker-compose.yml logs -f

# Вход в контейнер PHP
shell:
	docker-compose -f docker-compose.yml exec app bash

# Выполнение composer команд
composer:
	docker-compose -f docker-compose.yml exec app composer $(cmd)

# Выполнение PHP команд
php:
	docker-compose -f docker-compose.yml exec app php $(cmd)

# Запуск тестов на тестовой базе данных
test:
	cp environments/dev/frontend/config/codeception-local.php frontend/config/
	cp environments/dev/frontend/config/main-local.php frontend/config/
	cp environments/dev/frontend/config/params-local.php frontend/config/
	cp environments/dev/frontend/config/test-local.php frontend/config/
	cp environments/dev/backend/config/codeception-local.php backend/config/
	cp environments/dev/backend/config/main-local.php backend/config/
	cp environments/dev/backend/config/params-local.php backend/config/
	cp environments/dev/backend/config/test-local.php backend/config/
	docker-compose -f docker-compose.yml exec db sh -c 'MYSQL_PWD=$$DB_ROOT_PASSWORD mysql -u root --silent -e "CREATE DATABASE IF NOT EXISTS $${DB_NAME} CHARACTER SET utf8 COLLATE utf8_unicode_ci;"'
	docker-compose -f docker-compose.yml exec db sh -c 'MYSQL_PWD=$$DB_ROOT_PASSWORD mysql -u root --silent -e "GRANT ALL PRIVILEGES ON $${DB_NAME}.* TO \"$${DB_USER}\"@\"%\";"'
	docker-compose -f docker-compose.yml exec db sh -c 'MYSQL_PWD=$$DB_ROOT_PASSWORD mysql -u root --silent -e "FLUSH PRIVILEGES;"'
	docker-compose -f docker-compose.yml exec app php yii_test migrate --interactive=0
	docker-compose -f docker-compose.yml exec app vendor/bin/codecept run unit -c common
	docker-compose -f docker-compose.yml exec app vendor/bin/codecept run unit -c backend
	docker-compose -f docker-compose.yml exec app vendor/bin/codecept run unit -c frontend

# Запуск тестов с покрытием кода
test-coverage:
	rm -rf common/tests/_output/coverage common/tests/_output/coverage.xml common/tests/_output/coverage.html
	rm -rf backend/tests/_output/coverage backend/tests/_output/coverage.xml backend/tests/_output/coverage.html
	rm -rf frontend/tests/_output/coverage frontend/tests/_output/coverage.xml frontend/tests/_output/coverage.html
	cp environments/dev/frontend/config/codeception-local.php frontend/config/
	cp environments/dev/frontend/config/main-local.php frontend/config/
	cp environments/dev/frontend/config/params-local.php frontend/config/
	cp environments/dev/frontend/config/test-local.php frontend/config/
	cp environments/dev/backend/config/codeception-local.php backend/config/
	cp environments/dev/backend/config/main-local.php backend/config/
	cp environments/dev/backend/config/params-local.php backend/config/
	cp environments/dev/backend/config/test-local.php backend/config/
	docker-compose -f docker-compose.yml exec db sh -c 'MYSQL_PWD=$$DB_ROOT_PASSWORD mysql -u root --silent -e "CREATE DATABASE IF NOT EXISTS $${DB_NAME} CHARACTER SET utf8 COLLATE utf8_unicode_ci;"'
	docker-compose -f docker-compose.yml exec db sh -c 'MYSQL_PWD=$$DB_ROOT_PASSWORD mysql -u root --silent -e "GRANT ALL PRIVILEGES ON $${DB_NAME}.* TO \"$${DB_USER}\"@\"%\";"'
	docker-compose -f docker-compose.yml exec db sh -c 'MYSQL_PWD=$$DB_ROOT_PASSWORD mysql -u root --silent -e "FLUSH PRIVILEGES;"'
	docker-compose -f docker-compose.yml exec app php yii_test migrate --interactive=0
	docker-compose -f docker-compose.yml exec app vendor/bin/codecept run unit --coverage --coverage-html --coverage-xml -c common
	docker-compose -f docker-compose.yml exec app vendor/bin/codecept run unit --coverage --coverage-html --coverage-xml -c backend
	docker-compose -f docker-compose.yml exec app vendor/bin/codecept run unit --coverage --coverage-html --coverage-xml -c frontend

# Сидирование данных
seed:
	docker-compose -f docker-compose.yml exec app php yii seed

# Сидирование пользователей
seed-users:
	docker-compose -f docker-compose.yml exec app php yii seed/users

# Сидирование категорий
seed-categories:
	docker-compose -f docker-compose.yml exec app php yii seed/categories

# Сидирование ссылок
seed-links:
	docker-compose -f docker-compose.yml exec app php yii seed/links

# Очистка тестовых данных
seed-clear:
	docker-compose -f docker-compose.yml exec app php yii seed/clear

# Очистка кеша приложения
cache-clear:
	docker-compose -f docker-compose.yml exec app php yii cache/flush-all
	docker-compose -f docker-compose.yml exec app php yii cache/flush-all -c backend
	docker-compose -f docker-compose.yml exec app php yii cache/flush-all -c frontend

# Очистка кеша схемы базы данных
cache-schema:
	docker-compose -f docker-compose.yml exec app php yii cache/flush-schema
	docker-compose -f docker-compose.yml exec app php yii cache/flush-schema -c backend
	docker-compose -f docker-compose.yml exec app php yii cache/flush-schema -c frontend

# Очистка кеша ассетов
cache-assets:
	docker-compose -f docker-compose.yml exec app php yii asset/compress --interactive=0
	docker-compose -f docker-compose.yml exec app php yii asset/compress --interactive=0 -c backend
	docker-compose -f docker-compose.yml exec app php yii asset/compress --interactive=0 -c frontend

# Очистка всех типов кеша
cache-all: cache-clear cache-schema cache-assets

# Очистка runtime директорий
runtime-clear:
	rm -rf backend/runtime/cache/*
	rm -rf backend/runtime/debug/*
	rm -rf backend/runtime/logs/*
	rm -rf frontend/runtime/cache/*
	rm -rf frontend/runtime/debug/*
	rm -rf frontend/runtime/logs/*
	rm -rf common/runtime/cache/*
	rm -rf runtime/cache/*

# Полная очистка (кеш + runtime)
clean: cache-all runtime-clear

 