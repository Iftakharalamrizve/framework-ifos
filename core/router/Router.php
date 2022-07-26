<?php

namespace e2c\mvc\router;

use e2c\mvc\Application;
use e2c\mvc\Request;
use e2c\mvc\Response;

class Router
{
    /**
     * The property  store request instance  this property .
     *
     * @var \e2c\mvc\Request
     */
    public Request $request;

    /**
     * The property  store response instance  this property .
     *
     * @var \e2c\mvc\Response
     */
    private Response $response;

    /**
     * The property use for store all route list
     *
     * @var array
     */
    private array $routes = [];

    /**
     * Application Registered  Middleware List
     *
     * @var array
     */
    protected array $middleware = [];


    /**
     * The property use for store current route method  type for middleware check 
     *
     * @var array
     */
    protected String $methodType;

    /**
     * The property use for store current route method  path for middleware check 
     *
     * @var array
     */
    protected String $methodPath;

    /**
     * Assign Request and Response class instance in this class property
     *
     * @param \e2c\mvc\Request  $request
     * @param \e2c\mvc\Response $response
     */

    public function __construct(Request $request , Response $response , array $middleware)
    {
        $this->request = $request;
        $this->response = $response;
        $this->middleware = $middleware;
    }


    /**
     * Receive Route get method path and callback
     * Path example : /home . /contact
     * This Method get only get request from route
     * Callback example : [ControllerName::class,'methodName']
     * Method type and path store global property for use middleware
     *
     * @param String $path
     * @param        $callback
     */
    final public function get( String $path, $callback)
    {
        $this->methodType = 'get';
        $this->methodPath = $path;
        $this->routes['get'][$path] = $callback;
        return $this;

    }

    /**
     * Receive Route get method path and callback
     * Path example : /home . /contact
     * This Method get only post request from route
     * Callback example : [ControllerName::class,'methodName']
     * Method type and path store globale property for use middleware 
     *
     * @param String $path
     * @param        $callback
     */

    final public function post( String $path,  $callback)
    {
        $this->methodType = 'post';
        $this->methodPath = $path;
        $this->routes['post'][$path] = $callback;

        return $this;
    }


    /**
     * @param ...$arrayMiddleware
     * @todo Need to implement unregistered middleware  error
     */
    final public function middleware( ...$arrayMiddleware):void
    {

        foreach ($arrayMiddleware as $middleware){
            if(array_key_exists ( $middleware , $this->middleware)){
                $middlewareClassPath = $this->middleware[$middleware];
                $this->routes[$this->methodType][$this->methodPath]['middleware'][] = $middlewareClassPath;
//                $middlewareClassObj->handle($this->request);
            }
        }
    }


    /**
     * Get Request Path and Method
     * Path example = '/home' and Method Example : index
     * Callback call from routes array use method and path key
     * If callback not found in routes array then return 404 error
     * if callback is string then direct return render and load page
     * if call back is array then it has controller and method
     * Note : Operation perform depend on controller and method name and load file
     *
     * @return mixed
     */
    final public function  resolve(): string
    {

       $path = $this->request->getPath();
       $method = $this->request->getMethod();
       $callback = $this->routes[$method][$path] ?? false;
       $middleware = $this->routes[$method][$path]['middleware']??[];

       if(count ( $middleware)>0){
           foreach ($middleware as $item){
               $middlewareObj = new $item();
               $middlewareObj->handle($this->request);
           }
       }

       if($callback === false){
           $this->response->setStatusCode(404);
           return $this->errorLayoutLoad(404);
       }

       if(is_string($callback)){
            return $this->renderView($callback);
       }

       if(is_array($callback)){
           if(isset($callback['middleware'])){
                array_pop($callback);
           }
           Application::$app->controller = new $callback[0]() ;
           $callback[0] = Application::$app->controller;
       }

        return  call_user_func($callback,$this->request);
    
    }


    /**
     * This method return main layout after formation
     *
     * @param String $view
     * @param array  $params
     * @return array|bool|string
     */
    final public function renderView( string $view , array $params = [])
    {
        $layoutView = $this->layoutView();
        $loadContentView = $this->layoutContentView($view , $params);
        return str_replace('{{content}}',$loadContentView,$layoutView) ;
    }


    /**
     * This method create view layout which one user want to append
     *
     * @return false|string
     */
    final public function layoutView()
    {
        $name = Application::$app->controller->layout;
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$name.php";
        return ob_get_clean();
    }


    /**
     * This method create main layout which layout user want to append
     *
     * @param $view
     * @param $params
     * @return false|string
     */
    final public function layoutContentView( $view , $params)
    {
        $request = Application::$app->request;
        $request->errors = Application::$app->controller->errors;
        foreach ($params as $key=>$value){
            $$key = $value ;
        }
        $name = str_replace('.','/',$view);
        ob_start();
        include_once Application::$ROOT_DIR."/views/$name.php";
        return ob_get_clean();
    }

    /**
     * This method show error layout
     *
     * @param $code
     * @return false|string
     */
    final public function errorLayoutLoad( $code)
    {
        ob_start();
        include_once Application::$ROOT_DIR."/views/errors/$code.php";
        return ob_get_clean();
    }
}