<?php

namespace App\Models;

use PDO;
use App\Core\Model;

class Users extends Model{
    public $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'users';
    }

    public function add_user($login, $email, $password){
        $password = password_hash($password, PASSWORD_DEFAULT);
        $this->query("INSERT INTO `{$this->table}` (`id`, `login`, `email`, `password`) VALUES (NULL, '{$login}', '{$email}', '{$password}')");
    }

    public function user_exist($login, $email):bool{
        $col = $this->row("SELECT COUNT(*) FROM `{$this->table}` WHERE `login` = '{$login}' OR `email` = '{$email}'");
        if($col[0]["COUNT(*)"] != 0){
            return true; 
        }

        return false;
    }

    public function user_login($login, $password){
        $col = $this->row("SELECT * FROM `{$this->table}` WHERE `login` = '{$login}'");
        if(count($col)==0){
            return false;
        }
        $checkPassword = password_verify($password, $col[0]['password']);
        if($checkPassword){
            return [
                'id' => $col[0]['id'], 
                'login' => $col[0]['login']
            ]; 
        }

        return false;
    }
}