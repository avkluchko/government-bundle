FROM php:7.1-cli

RUN apt-get update && apt-get install -y \
        libzip-dev unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /app
