<?php

namespace e2c\mvc;


abstract class Model
{
    public  $mysql;

    public function __construct()
    {
        $this->connection ();
    }



    public function connection():void
    {
        $this->mysql = Application::$app->db->mysql instanceof \PDO?Application::$app->db->mysql:null;
    }



}