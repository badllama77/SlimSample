<?php
namespace ESoft\SlimSample;

use org\bovigo\vfs\vfsStream;
use Slim\Http\Environment;
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
    }
}
