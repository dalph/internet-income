.PHONY: up down build restart logs shell composer start

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
	docker-compose -f docker-compose.yml restart

# Полный перезапуск (остановка + запуск)
restart-full:
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
	docker-compose -f docker-compose.yml exec db sh -c 'MYSQL_PWD=$$MYSQL_ROOT_PASSWORD mysql -u root --silent -e "CREATE DATABASE IF NOT EXISTS internet_income_test CHARACTER SET utf8 COLLATE utf8_unicode_ci;"'
	docker-compose -f docker-compose.yml exec db sh -c 'MYSQL_PWD=$$MYSQL_ROOT_PASSWORD mysql -u root --silent -e "GRANT ALL PRIVILEGES ON internet_income_test.* TO \"internet_income\"@\"%\";"'
	docker-compose -f docker-compose.yml exec db sh -c 'MYSQL_PWD=$$MYSQL_ROOT_PASSWORD mysql -u root --silent -e "FLUSH PRIVILEGES;"'
	docker-compose -f docker-compose.yml exec app php yii_test migrate --interactive=0
	docker-compose -f docker-compose.yml exec app vendor/bin/codecept run unit -c common 