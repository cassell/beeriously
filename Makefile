default: beer

RUN_COMMAND = docker run --rm --interactive --tty --network beeriously_default --volume `pwd`:/app --user $(id -u):$(id -g) --workdir /app
RUN_COMMAND_ON_PHP = $(RUN_COMMAND) beeriously_php-fpm
RUN_COMMAND_ON_NODE = $(RUN_COMMAND) beeriously_webpack

beer: down build up install clean-database run-migrations yarn-install encore

down:
	docker-compose down	

build:
	docker-compose build

up:
	docker-compose up -d

install:
	$(RUN_COMMAND_ON_PHP) composer install


update:
	$(RUN_COMMAND_ON_PHP) composer update

unit:
	$(RUN_COMMAND_ON_PHP) /app/vendor/bin/phpunit --configuration /app/src/Tests/Unit/phpunit.xml.dist

integration:
	$(RUN_COMMAND_ON_PHP) /app/vendor/bin/phpunit --configuration /app/src/Tests/Integration/phpunit.xml.dist

ssh:
	$(RUN_COMMAND_ON_PHP) bash

chrome:
	open -a "Google Chrome" http://localhost:62337/

clean-database:

	docker run -it --rm --network beeriously_default mariadb:10.1 mysql -hmariadb -uroot -p64ounces --batch -e "drop database if exists beeriously; create database beeriously;"

run-migrations:
	$(RUN_COMMAND_ON_PHP) /app/bin/console doctrine:migrations:migrate --no-interaction -v

refresh-db: clean-database run-migrations

migration:
	$(RUN_COMMAND_ON_PHP) /app/bin/console doctrine:migrations:generate

entities:
	$(RUN_COMMAND_ON_PHP) /app/bin/console doctrine:mapping:convert annotation ./var/dev/Entity --from-database --force

yarn-install:
	$(RUN_COMMAND_ON_NODE) yarn install

encore:
	$(RUN_COMMAND_ON_NODE) yarn run encore dev

cs-fixer-dry:
	$(RUN_COMMAND_ON_PHP) vendor/bin/php-cs-fixer fix --diff --dry-run -v --using-cache=no

cs-fixer:
	$(RUN_COMMAND_ON_PHP) vendor/bin/php-cs-fixer fix --using-cache=no