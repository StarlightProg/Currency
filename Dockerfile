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

# Установка зависимостей проекта
RUN composer install

#RUN ./vendor/bin/doctrine-migrations migrate

#RUN chmod +x /var/www/html/update-currencies.php

#RUN echo "* * * * * php /var/www/html/update-currencies.php >> /dev/null 2>&1" >> /etc/cron.d/cron

#CMD cron && tail -f /var/www/html/var/log/cron.log

# RUN chown -R www-data:www-data /var/www/html/