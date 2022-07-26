<?php

namespace e2c\mvc;

trait RenderTrait
{
    /**
     * @param string $baseLayout
     * @param string $name
     * @param array  $params
     * @return array|false|string|string[]
     */
    public function render( string $baseLayout = 'layout', string $name, array $params=[])
    {
        $this->layout = $baseLayout ;
        return Application::$app->router->renderView( $name,$params);
    }

    /**
     * @param string $name
     * @param array  $param
     */
    public function setLayout( string $name='layout', array $param=[])
    {
        $this->layout = $name ;
    }

    /**
     * @param array $errors
     * @return $this
     */
    public function withErrors( array $errors = []) : Controller
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * @return $this
     */
    public function withInputs() : Controller
    {
        $this->withInput = true ;
        return $this;
    }


}