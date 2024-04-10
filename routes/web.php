<?php

use Phalcon\Mvc\Application as Web;
use Phalcon\Di\FactoryDefault;

$di = new FactoryDefault();
$app = new Web($di);

echo $app->handle($_SERVER['REQUEST_URI'])->getContent();