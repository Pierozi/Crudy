FROM plab/docker-php:7.0-fpm-xdebug

RUN apt-get update && apt-get install -y \
	&& docker-php-ext-configure mysqli \
	&& docker-php-ext-install mysqli

RUN ln -sf /usr/share/zoneinfo/Europe/Paris /etc/localtime

