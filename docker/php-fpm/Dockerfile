FROM phpdockerio/php72-fpm:latest

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
    	php-memcached \
    	php-redis \
    	php7.2-pgsql \
    	php7.2-imagick \
	    php7.2-imap \
		php7.2-mbstring \
		php-xdebug \
		git openssh-client \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

WORKDIR "/application"