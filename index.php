<?php

use App\Core\Router;

require_once 'vendor/autoload.php';

// spl_autoload_register(function($class) {
//     $path = str_replace('\\', '/', $class.'.php');
//     if (file_exists($path)) {
//         require $path;
//     }
// });

session_start();

$router = new Router;
$router->run();

// RewriteEngine on
// RewriteCond %{REQUEST_FILENAME} !-f
// RewriteCond %{REQUEST_FILENAME} !-d
// RewriteRule ^(.*)$ index.php

