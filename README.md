Приложение со стандортными функциями регистрации и авторизации. В личном кабинете пользователь может увидеть акутальные курсы валют с сайта ЦБ РФ. Данные обновляются каждые 3 часа при помощи cron.

Установка:
<p>Создать .env со своими настройками</p>
<p>Запустить терминал</p>
<p>"docker-compose up --build"</p>
<p>"docker-compose exec app composer install"</p>
<p>"docker-compose exec app ./vendor/bin/doctrine-migrations migrate"</p>
<p>http://localhost:8000</p>
