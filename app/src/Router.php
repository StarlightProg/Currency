<?php
    namespace App;
    use Exception;

    class Router{
        private array $routes;

        public function regFile(string $method, string $route, callable|array $action): self{
            $this->routes[$method][$route] = $action;

            return $this;
        }

        public function get(string $route, callable|array $action): self{
            return $this->regFile('get',$route,$action);
        }

        public function post(string $route, callable|array $action): self{
            return $this->regFile('post',$route,$action);
        }

        public function routes(){
            return $this->routes;
        }
        
        public function resolve(string $requestUri,string $method){
            $route = explode('?',$requestUri)[0];
            $action = $this->routes[$method][$route] ?? null;
            if(!$action){
                throw new Exception();
            }
            if(is_callable($action)){
                return call_user_func($action);
            }
            if(is_array($action)){
                [$class,$method]= $action;
                if(class_exists($class)){
                    $class = new $class();
                    
                    if(method_exists($class,$method)){
                       
                        return call_user_func_array([$class,$method],[]);
                    }
                }
            }

            throw new Exception();
        }
    }