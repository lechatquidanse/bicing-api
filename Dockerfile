FROM php:7.1-fpm-alpine AS bicing_api_php

ENV FETCH_PACKAGES \
        libpq \
        libzip \
        git \
        openssl \
        unzip \
        zlib-dev

ENV BUILD_PACKAGES \
        postgresql-dev

ENV PHP_EXTENSIONS \
        pdo \
        pdo_pgsql \
        zip

RUN set -ex \
    && apk add --no-cache --virtual .fetch-deps $FETCH_PACKAGES \
    && apk add --no-cache --virtual .build-deps $BUILD_PACKAGES \
    && docker-php-ext-install $PHP_EXTENSIONS \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && ln -snf /usr/share/zoneinfo/Europe/Paris /etc/localtime \
    && echo Europe/Paris > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', Europe/Paris > /usr/local/etc/php/conf.d/tzone.ini \
    && apk del .fetch-deps

WORKDIR /var/www/bicing-api

COPY . ./

FROM nginx:1.15.1-alpine AS bicing_api_nginx

WORKDIR /var/www/bicing-api

COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/nginx/conf.d/ /etc/nginx/conf.d

#COPY --from=bicing_api_php /var/www/bicing-api/public/bundles ./public/bundles
