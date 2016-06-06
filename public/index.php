<?php
define('APPPATH', realpath('../'));

require_once (APPPATH . "/vendor/autoload.php");

$config = require_once (APPPATH . "/app/config/config.php");
$routes = include_once (APPPATH . "/app/config/routes.php");

$whoops = new \Whoops\Run();
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
$whoops->register();

$app = new Skeleton\Library\Bootstrap($routes, $config);

$app->injectDependecy([
    'view' => "\Skeleton\Service\TwigViewService",
]);

$app->run();