![issues](https://img.shields.io/github/issues/Iftakharalamrizve/framework-ifos??style=flat&logo=appveyor)
![forks](https://img.shields.io/github/forks/Iftakharalamrizve/framework-ifos?style=flat&logo=appveyor)
![stars](https://img.shields.io/github/stars/Iftakharalamrizve/framework-ifos?style=flat&logo=appveyor)


# Php framework ifos(idealistic framework in open source)
This is a simple lightweight framework built with PHP. By which a developer can easily create a  raw PHP project easily.
 One can easily connect many <b>databases here also use Route, View, Controller, Model, Migration, Validation, and Default Authentication</b> can be easily used.\
<br />

## Installation
Create project with composer using the following command:

```
composer create-project iftakharalamrizve/framework-ifos proejct-name
```

## .env configuration 
Create project with composer using the following command:

```
cp .env.example .env
```

```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

## Route Configuration In Project  
Route File Default have separation mode. User can define multiple route file in route folder . If any one change this mode , easily configure from bootstrap/app.php file.
### Route Define in Route file 
```php
<?php
use app\controllers\AuthController;

$router->get( '/registration', [ AuthController::class , 'register']);
$router->post('/registration',[AuthController::class,'register']);
$router->get('/login',[AuthController::class,'login']);
$router->post('/login',[AuthController::class,'login']);
$router->get('/logout',[AuthController::class,'logout']);
$router->get('/profile',[AuthController::class,'profile']);
```

### Middleware Configuration
Middleware Define in middleware folder . Registred middleware in config/config.php file . Register Middleware in routeMiddleware group. 
```shell
 config/config.php
 'routeMiddleware'=>[
        'auth'=>app\middleware\AuthMiddleware::class
  ]
```
```php
#Example Middleware use in route file
<?php
    $router->get('/profile',[AuthController::class,'profile'])->middleware('auth');
 ?>
 
#Example Middleware Class
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

# License

The MIT License (MIT). Please see [License](LICENSE) for more information.
