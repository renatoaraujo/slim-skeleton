<?php

define('APPPATH', realpath('../'));
require_once (APPPATH . "/vendor/autoload.php");
$config = require_once (APPPATH . "/src/config/config.php");
$routes = include_once (APPPATH . "/src/config/routes.php");

$app = new Skeleton\Library\Bootstrap($routes, $config);

$app->injectDependecy('view', new \Skeleton\Service\TwigViewService());

$app->run();