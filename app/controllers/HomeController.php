<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\controllers;
use App\Models\User;

class HomeController extends controller{
    public function index($request, $response){
        return $this->view->render($response, 'home.html');
    }
    
}