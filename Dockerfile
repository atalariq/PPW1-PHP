FROM php:8.4-apache

RUN apt-get update && apt-get install -y libonig-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring

COPY php.ini /usr/local/etc/php/conf.d/custom.ini

COPY src/ /var/www/html/
