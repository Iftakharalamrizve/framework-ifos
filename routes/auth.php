<?php

use app\controllers\AuthController;

$router->get( '/registration', [ AuthController::class , 'register']);
$router->post('/registration',[AuthController::class,'register']);
$router->get('/login',[AuthController::class,'login']);
$router->post('/login',[AuthController::class,'login']);
$router->get('/logout',[AuthController::class,'logout']);
$router->get('/profile',[AuthController::class,'profile'])->middleware('auth');