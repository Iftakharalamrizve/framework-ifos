<?php

namespace app\controllers;

use e2c\mvc\auth\Auth;
use e2c\mvc\Controller;
use e2c\mvc\Request;
use app\models\User;
use app\request\RegistrationRequest;


class AuthController extends Controller
{
    protected RegistrationRequest $registrationRequest ;
    /**
     * @var \app\models\User
     */
    protected User $userModel;


    public function __construct()
    {
        $this->registrationRequest = new RegistrationRequest();
        $this->userModel = new User();
    }

    /**
     * @param \e2c\mvc\Request $request
     * @return array|false|string|string[]
     */
    public function register( Request $request)
    {

        if($request->isPost()){
            $errors = $request->validateRequest(
                [
                    'first_name'=>'required|max:256',
                    'last_name'=>'required|max:256',
                    'email'=>'required|email|unique:users,email',
                    'password'=>'required|max:6|min:1',
                    'c_password'=>'match:password'
                ]);
            $this->userModel->loadUserData($request->inputs);

            if(!$errors && $this->userModel->save()){
                $this->redirect('/');
            }
            return $this->withErrors($errors)->withInputs()->render('auth','auth.register');
        }
        return $this->render('auth','auth.register');
    }


    /**
     * @param \e2c\mvc\Request $request
     * @return array|false|string|string[]
     */
    public function login( Request $request)
    {
        if ($this->registrationRequest->isPost()){
            $errors = $this->registrationRequest->validateRequest(
                [
                    'email'=>'required|email',
                    'password'=>'required'
                ]
            );

           if(!$errors){
               $this->attemptLogin($request->inputs);
           }else{
               return $this->withErrors($errors)->withInputs()->render('auth','auth.login');
           }
        }
        return $this->render('auth','auth.login');
    }

    public function logout(Request $request)
    {
        if(Auth::logout()){
            return $this->redirect('/login');
        }
        return $this->redirect('/');
    }

    /**
     * @param array $data
     * @return false|void
     */
    public  function attemptLogin( array $data)
    {
        $findUser = $this->userModel->findOne(['email'=>$data['email']]);
        if (!$findUser) {
            return false;
        }
        if (password_verify($data['password'], $findUser->password)) {
            if(Auth::login ( $findUser)){
                return $this->redirect('/');
            }
            return $this->redirect('/login');
        }else{
            return $this->redirect('/login');
        }

    }

    public function profile()
    {
        $findUser = Auth::user();
        $data = ['title' => 'Pfofile Page','user'=>$findUser];
        if($findUser){
            return $this->render('layout','prifile',$data);
        }
        return $this->redirect('/');
    }
}