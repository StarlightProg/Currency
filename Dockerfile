FROM php:8.2-apache

RUN apt-get update && apt-get -y install \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo_mysql zip

RUN apt-get update && apt-get -y install cron

RUN a2enmod rewrite

RUN docker-php-ext-install pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY composer.json /var/www/html
COPY composer.lock /var/www/html

RUN composer install

COPY . /var/www/html/

WORKDIR /var/www/html/
