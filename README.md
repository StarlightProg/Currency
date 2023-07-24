Приложение со стандортными функциями регистрации и авторизации. В личном кабинете пользователь может увидеть акутальные курсы валют с сайта ЦБ РФ. Данные обновляются каждые 3 часа при помощи cron.

Установка:
Создать .env со своими настройками
Запустить терминал
"docker-compose up --build"
"docker-compose exec app composer install"
"docker-compose exec app ./vendor/bin/doctrine-migrations migrate"
http://localhost:8000
