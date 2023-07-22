<?php

namespace App\Core;

use Exception;

class Router {

    protected $routes = [];
    protected $params = [];
    
    public function __construct() {
        $arr = require 'app/Config/routes.php';
        
        foreach ($arr as $key => $val) {
            $this->add($key, $val);
        }
    }

    public function add($route, $params) {
        $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route);
        $route = '#^'.$route.'$#';
        $this->routes[$route] = $params;
    }

    public function match() {
        //$url = explode('?', trim($_SERVER['REQUEST_URI'], '/'))[0];
        // $url = trim($_SERVER['REQUEST_URI'], '/');
        // var_dump($url);
        // foreach ($this->routes as $route => $params) {
        //     if (preg_match($route, $url, $matches)) {
        //         $this->params = $params;
        //         return true;
        //     }
        // }
        // return false;


        $url = explode('?', trim($_SERVER['REQUEST_URI'], '/'))[0];
        var_dump($url);
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        if (is_numeric($match)) {
                            $match = (int) $match;
                        }
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function run(){
        
        if ($this->match()) {
            $path = 'App\Controllers\\'.ucfirst($this->params['controller']).'Controller';
            
            if (class_exists($path)) {
                $action = $this->params['action'];
                if (method_exists($path, $action)) {
                    $controller = new $path($this->params);
                    $controller->$action();
                } else {
                    View::errorCode(404);
                }
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        }
    }

}