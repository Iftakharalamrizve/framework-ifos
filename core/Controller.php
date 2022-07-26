<?php

namespace e2c\mvc;



class Controller
{
    use RenderTrait,RedirectTrait;
    /**
     * @var string
     */
    public String $layout = 'layout';

    /**
     * @var array
     */
    public array $errors = [] ;

    /**
     * @var bool
     */
    public bool $withInput = false;



}