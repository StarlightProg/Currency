<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Core\Model;

class LoginController extends Controller{

    public function index(){
        if(isset($_SESSION['login'])){
            header("location: /profile/{$_SESSION["id"]}"); // перенаправляет в профиль
        }
        return $this->view->render('Вход');
    }

    public function login(){
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header("location: /");
            exit();
        }

        $model = $this->loadModel('Users');

        $login = $this->purifyData("login");
        $password = $this->purifyData("password");

        if($this->emptyInputSignup($login,$password)){
            header("location: /?error=emptyinput");
            exit();
        }

        if($data = $model->user_login($login, $password)){
            var_dump($data);
            session_start();
            $_SESSION["id"] = $data["id"];
            $_SESSION["login"] = $data["login"];
            header("location: /profile/{$data["id"]}"); // перенаправляет в профиль
        }
    }

    protected function purifyData(string $str){ //защита от инъекций
        $_POST[$str] ??= '';

        return htmlspecialchars(stripslashes($_POST[$str]));
    }

    protected function emptyInputSignup($login,$password):bool{ //проверить есть ли пустое поле
        foreach(func_get_args() as $param){
            if(empty($param)){
                return true;
            }
        }
        return false;
    }
}