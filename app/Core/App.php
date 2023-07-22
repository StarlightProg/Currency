<?php

namespace App\Core;

use App\Core\Router;

class App
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function run(){
        echo $this->router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));
    }
}