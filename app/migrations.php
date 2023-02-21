<?php

use App\Database;


require __DIR__.'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

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