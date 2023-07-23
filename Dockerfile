FROM php:8.2-apache

RUN docker-php-ext-install pdo_mysql

RUN apt-get update && apt-get -y install cron

COPY . /var/www

WORKDIR /var/www

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Установка зависимостей проекта
RUN composer install

RUN chown -R www-data:www-data /var/www