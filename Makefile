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

 