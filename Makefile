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