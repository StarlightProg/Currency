<?php


use App\App;
use App\Classes\Login;
use App\Classes\Registration;
use App\Classes\Profile;
use App\Database;
use App\Router;

require __DIR__.'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Router();

define('VIEW_PATH',__DIR__.'/views'); //путь к html документам

$router //маршрутизатор между страницами
	->get('/',[Login::class,'index'])
	->get('/registration',[Registration::class,'index'])
	->get('/profile',[Profile::class,'index'])
	->get('/profile?convert=true',[Profile::class,'index'])
	->post('/',[Login::class,'login'])
	->post('/registration',[Registration::class,'register'])
	;

new Database();
(new App($router))->run();