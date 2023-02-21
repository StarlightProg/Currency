<?php
    namespace App\Classes;

    use App\Database;
    use App\View;

    class Login{
        public function index():string{
            return View::make('login')->render();
        }

        public function login(){
            $db = Database::db();
    
            $login = $this->purifyData("login");
            $password = $this->purifyData("password");
    
            if($this->emptyInputSignup($login,$password)){
                header("location: /registration?error=emptyinput");
                exit();
            }
            if($data = $this->uidExists($db,$login)){
                $passwordDB = $data["pwd"];
                $checkPassword = password_verify($password,$passwordDB);
                if($checkPassword){
                    session_start();
                    $_SESSION["login"] = $data["login"];
                    header("location: /profile");
                }
                else{
                    header("location: /?error=wrongpassword");
                    exit();
                }
            }
            else{
                header("location: /?error=wronglogin");
                exit();
            }
          
            return View::make('register')->render();
        }

        protected function purifyData(string $str){
            $_POST[$str] ??= '';
    
            return htmlspecialchars(stripslashes($_POST[$str]));
        }

        protected function emptyInputSignup($login,$password):bool{
            foreach(func_get_args() as $param){
                if(empty($param)){
                    return true;
                }
            }
            return false;
        }

        protected function uidExists($db,$login){
            $sql ="SELECT * FROM users WHERE login = ?";
            $stmt = mysqli_stmt_init($db);
            if(!mysqli_stmt_prepare($stmt,$sql)){
                header("location: /?error=connectionproblem");
                exit();
            }
    
            mysqli_stmt_bind_param($stmt,"s",$login);
            mysqli_stmt_execute($stmt);
    
            $resultData = mysqli_stmt_get_result($stmt);
    
            if($row = mysqli_fetch_assoc($resultData)){
                return $row;
            }
            else{
                return false;
            }
    
            mysqli_stmt_close($stmt);
        }
    }