<?php

namespace App\Core;

use Exception;

class View {

	public $path;
	public $route;
	public $layout = 'default';

	public function __construct($route) {
		$this->route = $route;
		$this->path = $route['controller'].'/'.$route['action']; 
	}

	public function render($title, $vars = []) {
		extract($vars);
		$path = 'app/Views/'.$this->path.'.php';
		// var_dump($path);
        // var_dump($path);
		if (file_exists($path)) {
			ob_start();
			require $path;
			$content = ob_get_clean();
            //var_dump($content);
			require 'app/Views/layouts/'.$this->layout.'.php';
		}
	}

	public function redirect($url) {
		header('location: '.$url);
		exit;
	}

	public static function errorCode($code) {
		http_response_code($code);
		$path = 'application/views/errors/'.$code.'.php';
		if (file_exists($path)) {
			require $path;
		}
		exit;
	}

	public function message($status, $message) {
		exit(json_encode(['status' => $status, 'message' => $message]));
	}

	public function location($url) {
		exit(json_encode(['url' => $url]));
	}

}	