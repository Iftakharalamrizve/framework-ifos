<?php


use app\controllers\ContactController;
use app\controllers\HomeController;

$router->get( '/', [ HomeController::class , 'index']);
$router->get('/contact',[ContactController::class,'index']);
$router->post('/contact',[ContactController::class,'save']);