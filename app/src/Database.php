<?php
//Настройка подключения к бд
namespace App;

use PDO;
use Exception;
use mysqli;

class Database
{
    private static $sqlconn;
    public function __construct()
    {
        static::$sqlconn = new mysqli(
            $_ENV['DB_HOST'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASS'],
            $_ENV['DB_DATABASE']
        );
    } 

    public static function db(): mysqli
    {
        return static::$sqlconn;
    }
    
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->sqlconn, $name], $arguments);
    }
}