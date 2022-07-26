<?php

namespace e2c\mvc\auth;

use e2c\mvc\Application;
use e2c\mvc\DBModel\DBModel;
use e2c\mvc\Session;

class Auth
{

    /**
     * @var $user
     */
    protected $user ;


    /**
     * @var Session
     */
    private Session $session;

    /**
     * @var \app\models\User|mixed|null
     */
    private $userClass;

    /**
     * User class object assign in userClass property
     * Session class object assign in session property
     */
    public function __construct()
    {
        $this->userClass = Application::$app->user;
        $this->session = Application::$app->session;
    }



    /**
     * Call all nonstatic method  via __call method
     * Note : Use this method  because use can call method statically and non statically
     * This method structure build for __calStatic method
     * @param $name
     * @param $arguments
     * @return mixed|void
     */
    public function __call($name, $arguments)
    {
        $name .= 'Auth';
        if (method_exists($this, $name)) {
            return call_user_func_array(array($this, $name), $arguments);
        }
    }



    /**
     * Call all nonstatic method  via __callStatic method
     * Note : Use this method  because use can call method statically and non statically
     * User can access nonstatic method static way
     * This method structure build for static and nonstatic way call
     *
     * @param $name
     * @param $arguments
     * @return mixed|void
     */
    public static function __callStatic($name, $arguments)
    {
        $name .= 'Auth';
        if (method_exists(Auth::class, $name)) {
            $authObject = new Auth();
            return call_user_func_array(array($authObject, $name), $arguments);
        }
    }



    /**
     * After Login use this method store all user data in session
     * This method only store user id in session
     * Then query full information from database depend on this id
     *
     * @param DBModel $user
     * @return bool
     */
    final public function loginAuth(DBModel $user) : bool
    {
        try {
            $this->user = $user;
            $primaryKey = $user->primaryKey();
            $primaryKeyValue = $user->{$primaryKey};
            $this->session->set('user', $primaryKeyValue);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


    /**
     *  This method basically clear current user session data
     *  After remove current user session data then logically user is unauthenticated
     *  So This method return true and user logout from system
     *
     * @return bool
     */
    final public function logoutAuth() : bool
    {
        $this->user = null;
        $this->session->remove('user');
        return true;
    }



    /**
     * This method check user is authenticated or unauthenticated
     * If user is authenticated then return false because he/she is not guest
     * If use is unauthenticated then method return true because he/she is guest
     *
     * @return bool
     */
    final public function isGuestAuth() : bool
    {
        $user = $this->userAuth();
        return !$user;
    }



    /**
     * This method fetch current use information form database
     *
     * @return mixed|null
     * @todo  Need farther development for future
     */
    final public function userAuth()
    {
        $userId = $this->session->get('user');
        if ($userId) {
            $key = $this->userClass->primaryKey();
            $userFind = $this->userClass->findOne([$key => $userId]);
            return !$userFind ? null : $userFind ;
        }
        return null;
    }

}