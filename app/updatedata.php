<?php

include_once __DIR__ . '/phpQuery.php';
require __DIR__.'/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$sqlconn = new mysqli(
    $_ENV['DB_HOST'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
    $_ENV['DB_DATABASE']
);
$sql ="INSERT INTO currencies (currency_name, currency_amount, exchange_rates) VALUES(?, ?, ?) ON DUPLICATE KEY UPDATE    
currency_amount=?, exchange_rates=?;";


$html = file_get_contents('https://www.cbr.ru/currency_base/daily/');
$pars = phpQuery::newDocument($html);

$currencies_table = pq('table.data')->children('tbody')->children('tr');
$skipFirst=true;
foreach ($currencies_table as $tr) {
    if($skipFirst){
        $skipFirst = false;
        continue;
    }
    $stmt = mysqli_stmt_init($sqlconn);
    mysqli_stmt_prepare($stmt,$sql);

    $amount = pq($tr)->find("td:eq(2)")->text();
    $name = pq($tr)->find("td:eq(3)")->text();
    $course = floatval(str_replace(',','.',pq($tr)->find("td:eq(4)")->text()));

    mysqli_stmt_bind_param($stmt,"sidid",$name,$amount,$course,$amount,$course);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

phpQuery::unloadDocuments();

