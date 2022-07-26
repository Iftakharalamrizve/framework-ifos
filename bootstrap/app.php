<?php

use e2c\mvc\Application;

$dotenv = Dotenv\Dotenv::createImmutable(dirname ( __DIR__));
$dotenv->load();

$config = require_once __DIR__.'/../config/config.php';
$app = new Application(dirname(__DIR__),$config);


$baseDir=scandir(dirname(__DIR__).'/routes');
$allRoutes=array_diff($baseDir,['.','..']);

foreach($allRoutes as $route)
{   $router=$app->router;
    require __DIR__.'/../routes/'.$route;
}

return $app;