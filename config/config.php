<?php

use app\models\User;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => $_ENV['APP_NAME']??'' ,

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */
    'database' => [
        'mysql' => [
            'driver' => 'mysql',
            'url' => '',
            'host' => $_ENV['DB_HOST']??'127.0.0.1',
            'port' => $_ENV['DB_PORT']??'3306',
            'database' => $_ENV['DB_DATABASE']??'',
            'username' =>$_ENV['DB_USERNAME']??'',
            'password' => $_ENV['DB_PASSWORD']??'',
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Default User Table Configure 
    |--------------------------------------------------------------------------
    |
    | This Class define whice Class is define for system user . 
    | This is the default class for system 
    |
    */
    'user'=>app\models\User::class,
    /*
    |--------------------------------------------------------------------------
    | Middleware  Configure 
    |--------------------------------------------------------------------------
    |
    | This Class is define  for system user .
    | This is the default class for system 
    |
    */
    'routeMiddleware'=>[
        'auth'=>app\middleware\AuthMiddleware::class
    ]

];