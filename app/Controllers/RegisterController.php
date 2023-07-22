<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Model;
use App\Core\Controller;


class RegisterController extends Controller{
    public function index(){
        if(isset($_SESSION['login'])){
            header("location: /profile/{$_SESSION["id"]}"); // перенаправляет в профиль
        }
        return $this->view->render('Регистрация');
    }

    public function register(){
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header("location: /register");
            exit();
        }

        $model = $this->loadModel('Users');

        $login = $this->purifyData("login");
        $email = $this->purifyData("email");
        $password = $this->purifyData("password");

        if($this->emptyInputSignup([$login, $email, $password])){
            header("location: /register?error=emptyinput");
            exit();
        }
        if($model->user_exist($login, $email)){
            header("location: /register?error=userexists");
            exit();
        }

        $model->add_user($login, $email, $password);
       
        return $this->view->redirect('/?reg=success');
    }

    protected function purifyData(string $str){
        $_POST[$str] ??= '';

        return htmlspecialchars(stripslashes($_POST[$str]));
    }

    protected function emptyInputSignup($reg_fields):bool{ //проверить есть ли пустое поле
        foreach($reg_fields as $param){
            if(empty($param)){
                return true;
            }
        }
        return false;
    }
}