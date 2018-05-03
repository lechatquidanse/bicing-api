FROM php:7.1-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    openssl \
    git \
    unzip

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN ln -snf /usr/share/zoneinfo/Europe/Paris /etc/localtime && echo Europe/Paris > /etc/timezone
RUN printf '[PHP]\ndate.timezone = "%s"\n', Europe/Paris > /usr/local/etc/php/conf.d/tzone.ini
RUN "date"


WORKDIR /var/www/symfony
