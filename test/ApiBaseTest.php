<?php
namespace ESoft\SlimSample;

use org\bovigo\vfs\vfsStream;
use Slim\Http\Environment;
use Slim\Http\Request;
use ESoft\SlimSample\App;
use PHPUnit\Framework\TestCase;

class ApiBaseTest extends TestCase
{
    protected $app;
    protected $contact;

    public function setUp()
    {
        $root = vfsStream::setup();
        $environmentFile = vfsStream::newFile('.env')->at($root);
        $environmentFile->setContent('
            [Database]
            driver=sqlite
            host=127.0.0.1
            charset=utf8
            collation=utf8_unicode_ci
            database=:memory:
            ');
        $this->app = (new App($root->url()))->get();
        $this->contact = TestDataGenerator::populate();
    }

    /**
     * Mock environment for delete
     * @param  string $url url to include in mock request
     * @return response app response to mocked request
     */
    protected function delete($url)
    {
        $env = Environment::mock([
            'REQUEST_METHOD'         => 'DELETE',
            'REQUEST_URI'            => $url,
        ]);
        $req = Request::createFromEnvironment($env);
        $this->app->getContainer()['request'] = $req;

        return $this->app->run(true);
    }

    /**
     * Mock environment for get 
     * @param  string $url url to include in mock request
     * @return response app response to mocked request
     */
    protected function get($url)
    {
        $env = Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => $url,
            ]);
        $req = Request::createFromEnvironment($env);
        $this->app->getContainer()['request'] = $req;

        return $this->app->run(true);
    }

    /**
     * Mock environment for post
     * @param  string $url url to include in mock request
     * @param  string $body body data for request
     * @return response app response to mocked request
     */
    protected function post($url, $body)
    {
        $env = Environment::mock([
            'REQUEST_METHOD' => 'POST',
            'REQUEST_URI'    => $url,
        ]);
        $req = Request::createFromEnvironment($env)->withParsedBody($body);
        $this->app->getContainer()['request'] = $req;

        return $this->app->run(true);
    }
}
