default: beer

.PHONY: beer fresh down build up install update unit integration ssh chrome drop-database create-database refresh migration entities yarn-install encore cs-fixer-dry cs-fixer php node cache translations diff selenium vnc cleanup-symfony-bundles sauce-chrome sauce-firefox stan

NGINX_WEB_PORT = 62337
RUN_COMMAND = docker run --rm --interactive --tty --network beeriously_default --volume `pwd`:/app -v $(HOME)/.composer:/root/.composer --workdir /app
RUN_COMMAND_ON_PHP = $(RUN_COMMAND) beeriously_php-fpm
RUN_COMMAND_ON_NODE = $(RUN_COMMAND) beeriously_webpack

beer: down cleanup-symfony-bundles build up install create-database run-migrations yarn-install encore

fresh: drop-database beer

down:
	docker-compose down

cleanup-symfony-bundles:
	rm -rf public/bundles/*

build:
	docker-compose build

up:
	docker-compose up -d

install:
	$(RUN_COMMAND_ON_PHP) composer install

update:
	$(RUN_COMMAND_ON_PHP) composer update

unit:
	$(RUN_COMMAND_ON_PHP) /app/vendor/bin/phpunit --configuration /app/tests/Unit/phpunit.xml.dist

integration:
	$(RUN_COMMAND_ON_PHP) /app/vendor/bin/phpunit --configuration /app/tests/Integration/phpunit.xml.dist

ssh:
	$(RUN_COMMAND_ON_PHP) bash

chrome:
	open -a "Google Chrome" http://localhost:$(NGINX_WEB_PORT)/

translate:
	open -a "Google Chrome" http://localhost:$(NGINX_WEB_PORT)/en/admin/_trans

drop-database:
	docker exec -it -u postgres beeriously_postgres_1 dropdb beeriously

create-database:
	$(RUN_COMMAND_ON_PHP) /app/bin/console doctrine:database:create


run-migrations:
	$(RUN_COMMAND_ON_PHP) /app/bin/console doctrine:migrations:migrate --no-interaction -v

refresh: drop-database create-database run-migrations

migration:
	$(RUN_COMMAND_ON_PHP) /app/bin/console doctrine:migrations:generate

entities:
	$(RUN_COMMAND_ON_PHP) /app/bin/console doctrine:mapping:convert annotation ./var/dev/Entity --from-database --force

yarn-install:
	$(RUN_COMMAND_ON_NODE) yarn install

encore:
	$(RUN_COMMAND_ON_NODE) yarn run encore dev

watch-assets:
	fswatch -o assets/ | xargs -n1 ./run_encore.bash

cs-fixer-dry:
	$(RUN_COMMAND_ON_PHP) vendor/bin/php-cs-fixer fix --diff --dry-run -v --using-cache=no

cs:
	$(RUN_COMMAND_ON_PHP) vendor/bin/php-cs-fixer fix --using-cache=no

php:
	@echo "$(RUN_COMMAND_ON_PHP)"

node:
	@echo "$(RUN_COMMAND_ON_NODE)"

cache:
	$(RUN_COMMAND_ON_PHP) /app/bin/console cache:clear --no-warmup
	$(RUN_COMMAND_ON_PHP) /app/bin/console cache:warmup -vvv

translations:
	$(RUN_COMMAND_ON_PHP) /app/bin/console translation:extract beeriously

diff:
	$(RUN_COMMAND_ON_PHP) /app/bin/console doctrine:migrations:diff --filter-expression="/^(?!sessions)/"

selenium:
	$(RUN_COMMAND_ON_PHP) /app/vendor/bin/behat --config=/app/behat.yml.dist --colors

sauce-chrome:
	$(RUN_COMMAND_ON_PHP) /app/vendor/bin/behat --config=/app/behat.saucelabs.yml --colors -p chrome

sauce-firefox:
	$(RUN_COMMAND_ON_PHP) /app/vendor/bin/behat --config=/app/behat.saucelabs.yml --colors -p firefox

vnc:
	open vnc://localhost:62339

stan:
	$(RUN_COMMAND_ON_PHP) /app/vendor/bin/phpstan analyse  --level=max /app/src /app/tests
