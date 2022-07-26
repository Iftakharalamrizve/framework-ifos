<?php

namespace app\controllers;

use e2c\mvc\Application;
use e2c\mvc\Controller;

class HomeController extends Controller
{
     public  function index()
     {
         $data = [
             'name'=>'Iftakhar Alam Rizve',
             'email' => 'iftakharalam32@gmail.com'
         ];
        return $this->render('layout','home',$data);
     }
}