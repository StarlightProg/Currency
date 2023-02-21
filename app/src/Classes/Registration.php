<?php

namespace App\Classes;

use App\Database;
use App\View;

class Registration{
    public function index():string{
        return View::make('register')->render();
    }

    public function register(){
        $db = Database::db();

        $login = $this->purifyData("login");
        $email = $this->purifyData("email");
        $password = $this->purifyData("password");

        if($this->emptyInputSignup($login,$email,$password)){
            header("location: /registration?error=emptyinput");
            exit();
        }
        if($this->uidExists($db,$login,$email)){
            header("location: /registration?error=userexists");
            exit();
        }
        
        $this->createUser($db,$login,$email,$password);
       
        return View::make('register')->render();
    }

    protected function purifyData(string $str){
        $_POST[$str] ??= '';

        return htmlspecialchars(stripslashes($_POST[$str]));
    }

    protected function emptyInputSignup($login,$email,$password):bool{ //проверить есть ли пустое поле
        foreach(func_get_args() as $param){
            if(empty($param)){
                return true;
            }
        }
        return false;
    }

    protected function uidExists($db,$login,$email):bool{ //проверить существует ли пользователь с таким логином
        $sql ="SELECT * FROM users WHERE login = ? or email = ?";
        $stmt = mysqli_stmt_init($db);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("location: /registration?error=connectionproblem");
            exit();
        }

        mysqli_stmt_bind_param($stmt,"ss",$login,$email);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        if(mysqli_fetch_assoc($resultData)){
            return true;
        }
        else{
            return false;
        }

        mysqli_stmt_close($stmt);
    }

    protected function createUser($db,$login,$email,$password):bool{ //создать нового пользователя
        $sql ="INSERT INTO users(login,email,pwd) VALUES (?,?,?);";
        $stmt = mysqli_stmt_init($db);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("location: /registration?error=connectionproblem");
            exit();
        }

        $password = password_hash($password,PASSWORD_DEFAULT); //хеширование пароля

        mysqli_stmt_bind_param($stmt,"sss",$login,$email,$password);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: /?reg=success");
        exit();
    }
}