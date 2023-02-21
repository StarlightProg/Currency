FROM php:8.1-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

COPY my_bash /bin/my_bash

COPY root /var/spool/cron/crontabs/root

RUN chmod +x /bin/my_bash

CMD crond -l 2 -f