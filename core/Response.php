<?php

namespace e2c\mvc;

class Response
{
    /**
     * Set Request Http code
     * @param $code
     */
    public function setStatusCode( $code):void
    {
        http_response_code($code);
    }

    public function redirect(string$url):void
    {
        header("Location: $url");
        exit;
    }
}