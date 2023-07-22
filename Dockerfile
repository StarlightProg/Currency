FROM php:7.4-apache

RUN apt-get update \
    && apt-get install -y cron \
    && docker-php-ext-install mysqli

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html/