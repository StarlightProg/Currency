<?php

namespace App;

use Exception;

class View
{
    public function __construct(
        protected string $view,
        protected array $params = []
    )   
    {
        
    }

    public static function make(string $str,array $params = []):static{
        return new static($str,$params);
    }

    public function render(): string{
        $viewPath = VIEW_PATH . '/' . $this->view . '.php';

        if (!file_exists($viewPath)) {
            throw new Exception();
        }

        ob_start();

        include $viewPath;

        return (string)ob_get_clean();
    }

}