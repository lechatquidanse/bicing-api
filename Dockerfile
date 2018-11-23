#########################################
########### Bicing API PHP ##############
#########################################
FROM php:7.2-fpm-alpine AS bicing_api_php

ENV FETCH_PACKAGES \
        libpq \
        libzip \
        git \
        openssl \
        unzip \
        zlib-dev

ENV BUILD_PACKAGES \
        alpine-sdk \
        autoconf \
        postgresql-dev

ENV PHP_EXTENSIONS \
        pdo \
        pdo_pgsql \
        zip

ENV COMPOSE_HTTP_TIMEOUT=3600
ENV COMPOSE_PROJECT_NAME=bicing-api
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN set -ex \
    && apk add --no-cache --virtual .fetch-deps $FETCH_PACKAGES \
    && apk add --no-cache --virtual .build-deps $BUILD_PACKAGES \
    && docker-php-ext-install $PHP_EXTENSIONS \
    && ln -snf /usr/share/zoneinfo/Europe/Paris /etc/localtime \
    && echo Europe/Paris > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', Europe/Paris > /usr/local/etc/php/conf.d/tzone.ini \
    && apk del .fetch-deps

WORKDIR /var/www/bicing-api

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN set -eux; \
	composer global require "hirak/prestissimo:^0.3" --prefer-dist --no-progress --no-suggest --classmap-authoritative; \
	composer clear-cache

ARG APP_ENV=prod
COPY composer.json composer.lock symfony.lock ./
RUN set -eux; \
	composer install --prefer-dist --no-dev --no-autoloader --no-scripts --no-progress --no-suggest; \
	composer clear-cache

COPY bin bin/
COPY config config/
COPY public public/
COPY src src/
COPY templates templates/

RUN set -eux; \
	composer dump-autoload --classmap-authoritative --no-dev; \
	composer run-script --no-dev post-install-cmd; \
	chmod +x bin/console; sync

#########################################
########## Bicing API NGINX #############
#########################################
FROM nginx:1.15.1-alpine AS bicing_api_nginx

WORKDIR /var/www/bicing-api

COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/nginx/conf.d/ /etc/nginx/conf.d

COPY --from=bicing_api_php /var/www/bicing-api/public/bundles ./public/bundles

#########################################
###### Bicing API PHP for dev env #######
#########################################
FROM bicing_api_php AS dev_bicing_api_php

RUN composer install --dev --prefer-dist --no-scripts --no-progress --no-suggest \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug
COPY ./docker/php-fpm/xdebug.ini  /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

ENV XDEBUG_IDE_KEY=PHPSTORM
ENV XDEBUG_REMOTE_ENABLE=1
ENV XDEBUG_REMOTE_PORT=9000
