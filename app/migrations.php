<?php

use App\Database;

include_once __DIR__ . '/phpQuery.php';
require __DIR__.'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//Создаём базу данных

$conn = new mysqli(
    $_ENV['DB_HOST'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS']);

$sql = "CREATE DATABASE {$_ENV['DB_DATABASE']}";
$conn->query($sql);
$conn->close();

//Создаём подключение к бд и создаём необходимые таблицы

new Database();

$db = Database::db();

$sql ="CREATE TABLE users(
	login varchar(255) PRIMARY KEY NOT NULL,
    email varchar(255) UNIQUE NOT NULL,
    pwd varchar(255) NOT NULL
);";

$stmt = mysqli_stmt_init($db);
mysqli_stmt_prepare($stmt,$sql);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

$sql ="CREATE table currencies(
	currency_name varchar(255) primary key,
    currency_amount int,
    exchange_rates float
);";

$stmt = mysqli_stmt_init($db);
mysqli_stmt_prepare($stmt,$sql);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

//Первый раз заполняем информацию по валютам(дальше будет раз в 3 часа обновляться само при помощи updatedata.php и cron) 

$sql ="INSERT INTO currencies (currency_name, currency_amount, exchange_rates) VALUES(?, ?, ?) ON DUPLICATE KEY UPDATE    
currency_amount=?, exchange_rates=?;";


//Парсим страницу ЦБ РФ
$html = file_get_contents('https://www.cbr.ru/currency_base/daily/');
$pars = phpQuery::newDocument($html);

$currencies_table = pq('table.data')->children('tbody')->children('tr');
$skipFirst=true;
foreach ($currencies_table as $tr) {
    if($skipFirst){
        $skipFirst = false;
        continue;
    }
    $stmt = mysqli_stmt_init($db);
    mysqli_stmt_prepare($stmt,$sql);

    $amount = pq($tr)->find("td:eq(2)")->text();
    $name = pq($tr)->find("td:eq(3)")->text();
    $course = floatval(str_replace(',','.',pq($tr)->find("td:eq(4)")->text()));

    mysqli_stmt_bind_param($stmt,"sidid",$name,$amount,$course,$amount,$course);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

phpQuery::unloadDocuments();