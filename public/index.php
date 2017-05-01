<?php

// set timezone for timestamps etc
date_default_timezone_set('UTC');

require __DIR__.'/../vendor/autoload.php';

$app = (new ESoft\SlimSample\App(__DIR__.'/../'))->get();

$app->run();
