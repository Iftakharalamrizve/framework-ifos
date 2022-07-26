<?php

namespace app\middleware;

use e2c\mvc\auth\Auth;
use e2c\mvc\Middleware;
use e2c\mvc\Request;

class AuthMiddleware extends Middleware
{
    public function handle ( Request $request )
    {
        if(Auth::isGuest()){
            return $request->redirect ( '/login');
        }

    }
}