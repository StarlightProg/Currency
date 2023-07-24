FROM php:8.2-apache

RUN apt-get update && apt-get -y install \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo_mysql zip

RUN apt-get update && apt-get -y install cron

RUN a2enmod rewrite

RUN docker-php-ext-install pdo_mysql

COPY . /var/www/html/

WORKDIR /var/www/html/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install
