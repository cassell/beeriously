default: beer

beer: down build up install

down:
	docker-compose down	

build:
	docker-compose build

up:
	docker-compose up -d

install:
	docker run --rm --interactive --tty --volume `pwd`:/app --user $(id -u):$(id -g) --workdir /app beeriously_php-fpm composer install


update:
	docker run --rm --interactive --tty --volume `pwd`:/app --user $(id -u):$(id -g) --workdir /app beeriously_php-fpm composer update

unit:
	docker run --rm --interactive --tty --volume `pwd`:/app --user $(id -u):$(id -g) --workdir /app beeriously_php-fpm /app/vendor/bin/phpunit --configuration /app/src/Tests/Unit/phpunit.xml.dist

ssh:
	docker run --rm --interactive --tty --volume `pwd`:/app --user $(id -u):$(id -g) --workdir /app beeriously_php-fpm bash

chrome:
	open -a "Google Chrome" http://localhost:62337/