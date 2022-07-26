<?php

namespace e2c\mvc;

abstract class Middleware
{
    public abstract function handle(Request $request);
}