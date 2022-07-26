<?php

namespace e2c\mvc;
use e2c\mvc\router\Router;
use app\models\User;

class Application
{

    /**
     * The application instance store this property .
     *
     * @var \e2c\mvc\Application
     */
    public static Application $app;

    /**
     * The Root Directory in this application.
     *
     * @var string
     */
    public static string $ROOT_DIR;

    /**
     * The application instance store this property .
     *
     * @var Router
     */
    public Router $router;

    /**
     * The application instance store this property .
     *
     * @var \e2c\mvc\Response
     */
    public Response $response;

    /**
     * The application instance store this property .
     *
     * @var \e2c\mvc\Request
     */
    public Request $request;

    /**
     * The application instance store this property .
     *
     * @var Session
     */
    public Session $session;

    /**
     * The application instance store this property .
     *
     * @var Databse
     */
    public Databse $db;
    

    /**
     * The application instance store this property .
     *
     * @var \e2c\mvc\Controller
     */
    public Controller $controller;


    /**
     * The application instance store Application User Model  .
     *
     * @var User
     */
    public  ?User $user;

    /**
     * Create a new  Application class instance for full framework example Application::$app.
     * Create Request and Response class instance
     * Create New router instance and pass Request and Response class
     *
     * @param string $dirName
     */
    public function __construct(string $dirName, array $config)
    {
        self::$ROOT_DIR = $dirName;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router( $this->request , $this->response , $config['routeMiddleware'] );
        $this->db = new Databse($config['database']);
        $this->session = new Session();
        $this->user = new $config['user']();
    }

    /**
     * Flush Router operation user run method .
     *
     * @return void
     */

    public function run():void
    {
        echo $this->router->resolve();
    }

}