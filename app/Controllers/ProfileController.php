<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Model;
use App\Core\Controller;
use App\Models\Currencies;

class ProfileController extends Controller{
    public function index(){
        // var_dump($this->route['id']);
        if(!isset($_SESSION['login'])){
            return $this->view->redirect('/');
        }
        
        if(($this->route['id'] != $_SESSION['id'])){
            return $this->view->redirect('/');
            header("location: /profile/{$_SESSION['id']}"); // перенаправляет в профиль
        }

        $currenciesModel = new Currencies();

        $currencies = $currenciesModel->get_currencies();

        return $this->view->render('Профиль', ["currencies" => $currencies]);
    }

    public function logout(){
        // var_dump($this->route['id']);
        session_destroy();

        return $this->view->redirect('/');
    }
}