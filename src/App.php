<?php

namespace ESoft\SlimSample;

class App
{
    protected $app;

    public function __construct($environmentFile)
    {
        $dotenv = new \Dotenv\Dotenv($environmentFile);
        $dotenv->overload();

    }

    public function get()
    {
        return $this->app;
    }
}
