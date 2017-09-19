default: down build up install

down:
	docker-compose down	

build:
	docker-compose build

up:
	docker-compose up -d

install:
	docker run --rm --interactive --tty --volume `pwd`:/app --user $(id -u):$(id -g) --workdir /app composer install


update:
	docker run --rm --interactive --tty --volume `pwd`:/app --user $(id -u):$(id -g) --workdir /app composer update

unit:
	