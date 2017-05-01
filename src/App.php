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

        $container = $this->app->getContainer();

        $this->initLogging($container);
        $this->initDatabase($container);

        $this->setUpDatabaseManager();
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

    private function initLogging(\Slim\Container $container)
    {
        $container['logger'] = function ($c) {
            $settings = $c->get('settings')['logger'];
            $logger = new \Monolog\Logger($settings['name']);
            $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], \Monolog\Logger::DEBUG));

            return $logger;
        };
    }

    private function initDatabase(\Slim\Container $container)
    {
        $container['db'] = function ($c) {
            $manager = new \Illuminate\Database\Capsule\Manager();
            $config = array_intersect_key($_SERVER, array_flip([
                'driver',
                'host',
                'username',
                'password',
                'charset',
                'collation',
                'database',
                'port']));
            $manager->addConnection($config);

            return $manager;
        };
    }
}
