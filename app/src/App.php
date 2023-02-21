<?php

namespace App;

class App
{
    //private static Database $db;

    public function __construct(protected Router $router)
    {
        //static::$db = new Database();
    }

    // public static function db(): Database
    // {
    //     return static::$db;
    // }

    public function run(){
        echo $this->router->resolve($_SERVER['REQUEST_URI'],strtolower($_SERVER['REQUEST_METHOD']));
    }
}