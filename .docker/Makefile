APP_CONTAINER = fornovea_app
DB_CONTAINER = fornovea_db
NGINX_CONTAINER = fornovea_nginx
DOCKER_COMPOSE = docker-compose -f docker-compose.yml


.PHONY: up
up:
	@echo "Запуск контейнеров..."
	$(DOCKER_COMPOSE) up -d --build


.PHONY: down
down:
	@echo "Остановка контейнеров..."
	$(DOCKER_COMPOSE) down


.PHONY: restart
restart:
	@echo "Перезапуск контейнеров..."
	$(DOCKER_COMPOSE) down
	$(DOCKER_COMPOSE) up -d

.PHONY: build
build:
	@echo "Сборка контейнеров..."
	$(DOCKER_COMPOSE) build

.PHONY: clean
clean:
	@echo "Остановка и удаление контейнеров, сетей и томов..."
	$(DOCKER_COMPOSE) down --volumes --remove-orphans

.PHONY: exec-app
exec-app:
	@echo "Вход в контейнер приложения..."
	docker exec -it $(APP_CONTAINER) bash

.PHONY: exec-db
exec-db:
	@echo "Вход в контейнер базы данных..."
	docker exec -it $(DB_CONTAINER) bash

.PHONY: migrations
migrations:
	@echo "Применение миграций базы данных..."
	docker exec -it $(APP_CONTAINER) php bin/console doctrine:migrations:migrate --no-interaction

.PHONY: create-db
create-db:
	@echo "Создание базы данных..."
	docker exec -it $(APP_CONTAINER) php bin/console doctrine:database:create

.PHONY: fixtures
fixtures:
	@echo "Загрузка данных фикстур в базу данных..."
	docker exec -it $(APP_CONTAINER) php bin/console doctrine:fixtures:load --no-interaction

.PHONY: serve
serve:
	@echo "Запуск встроенного сервера Symfony..."
	docker exec -it $(APP_CONTAINER) php bin/console server:start
