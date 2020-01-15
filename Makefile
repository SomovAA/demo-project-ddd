init: docker-down-clear docker-build docker-up app-init
app-init: composer-install migrations-install

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-build:
	docker-compose up --build -d

docker-config:
	docker-compose config

docker-restart: docker-down docker-up

composer-install:
	docker-compose run --rm php-cli composer install

# Запуск тестов. Тесты acceptance не включаю, т.к. будут провалены. Настроика selenium не помогает из-за проблем с заголовками
test:
	docker-compose run --rm php-cli vendor/bin/codecept run unit,functional,api

copy-env:
	cp .env.example .env

migrations-install:
	docker-compose run --rm php-cli vendor/bin/doctrine-migrations migrations:migrate --no-interaction

migrations-diff:
	docker-compose run --rm php-cli vendor/bin/doctrine-migrations migrations:diff
