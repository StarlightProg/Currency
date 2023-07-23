<?php

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

return [
    'dbname' => 'dbname',
    'user' => 'root',
    'password' => 'root',
    'host' => 'db',
    'driver' => "pdo_mysql",
];