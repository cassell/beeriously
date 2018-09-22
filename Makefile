default: beer

.PHONY: beer fresh down build up install update unit integration ssh chrome drop-database create-database refresh migration entities yarn-install encore cs-fixer-dry cs-fixer php node cache translations diff selenium vnc cleanup-symfony-bundles sauce-chrome sauce-firefox stan fixtures travis-ruby dev

NGINX_WEB_PORT = 62337
MAILCATCHER_WEB_PORT = 62340
RUN_COMMAND = docker run --rm --network beeriously_default --volume `pwd`:/app -v $(HOME)/.composer:/root/.composer --workdir /app
RUN_COMMAND_ON_PHP = $(RUN_COMMAND) --interactive --tty beeriously_php-fpm
RUN_COMMAND_ON_NODE = $(RUN_COMMAND) --interactive --tty beeriously_webpack
RUN_COMMAND_ON_NODE_NON_TTY = $(RUN_COMMAND) beeriously_webpack

travis-ruby:
	docker run --rm --interactive --tty --network beeriously_default --volume `pwd`:/app -v $(HOME)/.composer:/root/.composer --workdir /app ruby:2.2 bash
	#	gem install travis -v 1.8.9 --no-rdoc --no-ri

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
	$(RUN_COMMAND_ON_PHP) /app/vendor/bin/phpunit --no-coverage --stop-on-failure --configuration /app/tests/Unit/phpunit.xml.dist

unit-with-coverage: clear-coverage
	$(RUN_COMMAND_ON_PHP) /app/vendor/bin/phpunit --configuration /app/tests/Unit/phpunit.xml.dist

integration:
	$(RUN_COMMAND_ON_PHP) /app/vendor/bin/phpunit --no-coverage --stop-on-failure --configuration /app/tests/Integration/phpunit.xml.dist

integration-with-coverage: clear-coverage
	$(RUN_COMMAND_ON_PHP) /app/vendor/bin/phpunit --configuration /app/tests/Integration/phpunit.xml.dist

coverage: clear-coverage unit-with-coverage integration-with-coverage
	$(RUN_COMMAND_ON_PHP) /app/vendor/bin/phpcov merge /app/var/test/build/clover --html=/app/var/test/build/all/html --clover /app/var/test/build/all/clover

clear-coverage:
	rm -rf var/test
	mkdir var/test
	mkdir var/test/build
	mkdir var/test/build/clover

bash:
	$(RUN_COMMAND_ON_PHP) bash

chrome:
	open -a "Google Chrome" http://localhost:$(MAILCATCHER_WEB_PORT)/
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

encore-non-tty:
	$(RUN_COMMAND_ON_NODE_NON_TTY) yarn run encore dev

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

selenium: refresh
	$(RUN_COMMAND_ON_PHP) /app/vendor/bin/behat --config=/app/behat.docker-selenium.yml --colors

sauce-chrome: refresh
	$(RUN_COMMAND_ON_PHP) /app/vendor/bin/behat --config=/app/behat.docker-saucelabs.yml --colors -p win-chrome

sauce-firefox: refresh
	$(RUN_COMMAND_ON_PHP) /app/vendor/bin/behat --config=/app/behat.docker-saucelabs.yml --colors -p mac-firefox

vnc:
	open vnc://localhost:62339

stan:
	$(RUN_COMMAND_ON_PHP) /app/vendor/bin/phpstan analyse  --level=max /app/src /app/tests

fixtures:
	$(RUN_COMMAND_ON_PHP) /app/bin/console doctrine:fixtures:load --no-interaction -v

dev: fixtures
	$(RUN_COMMAND_ON_PHP) /app/bin/console beeriously:development:setupDevUser

