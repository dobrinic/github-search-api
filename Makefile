default: up

init:
	docker compose -p git_search up -d
	docker compose -p git_search exec -u www-data app composer install
	docker compose -p git_search exec -u www-data app php bin/console doctrine:migrations:migrate --no-interaction
	docker compose -p git_search exec -u www-data app yarn install
	docker compose -p git_search exec -u www-data app yarn encore dev
	@echo Wisit app on http://localhost:8080

up:
	docker compose -p git_search up -d
	@echo Wisit app on http://localhost:8080

down:
	docker compose -p git_search down

dev:
	docker compose -p git_search exec -u www-data app yarn encore dev

watch:
	docker compose -p git_search exec -u www-data app yarn encore dev --watch

composer:
	docker compose -p git_search exec -u www-data app composer install

console:
	docker compose -p git_search exec -u www-data app php bin/console $(c)

cache:
	docker compose -p git_search exec -u www-data app php bin/console cache:clear

bash:
	@docker compose -p git_search exec -it app bash