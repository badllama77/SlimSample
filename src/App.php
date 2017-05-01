<?php

namespace ESoft\SlimSample;

class App
{
    protected $app;

    public function __construct($environmentFile)
    {
        $dotenv = new \Dotenv\Dotenv($environmentFile);
        $dotenv->overload();

        $settings = require __DIR__.'/settings.php';
        $this->app = new \Slim\App($settings);

    }

    public function get()
    {
        return $this->app;
    }

    private function setUpDatabaseManager()
    {
        $database = $this->app->getContainer()->get('db');
        $database->setAsGlobal();
        $database->bootEloquent();
    }
}
