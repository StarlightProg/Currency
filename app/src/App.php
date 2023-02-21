<?php

namespace App;

class App
{

    public function __construct(protected Router $router)
    {

    }

    public function run(){
        echo $this->router->resolve($_SERVER['REQUEST_URI'],strtolower($_SERVER['REQUEST_METHOD']));
    }
}