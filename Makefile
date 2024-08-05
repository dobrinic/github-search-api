default: up

USER_ID := $(shell id -u)

init:
	USER_ID=$(USER_ID) docker compose -p git_search up -d --build
	docker compose -p git_search exec app composer install
	docker compose -p git_search exec app yarn install
	docker compose -p git_search exec app yarn encore dev
	docker compose -p git_search exec app php bin/console doctrine:migrations:migrate --no-interaction

up:
	docker compose -p git_search up -d

down:
	docker compose -p git_search down

dev:
	docker compose -p git_search exec app yarn encore dev

watch:
	docker compose -p git_search exec app yarn encore dev --watch

composer:
	docker compose -p git_search exec app composer install

console:
	docker compose -p git_search exec app php bin/console $(c)

cache:
	docker compose -p git_search exec app php bin/console cache:clear

test:
	docker compose -p git_search exec app php vendor/bin/phpunit

bash:
	@docker compose -p git_search exec -it app bash