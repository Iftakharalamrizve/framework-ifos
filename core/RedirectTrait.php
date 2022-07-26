<?php

namespace e2c\mvc;

trait RedirectTrait
{

    public function redirect($url)
    {
        return Application::$app->response->redirect($url);
    }

}