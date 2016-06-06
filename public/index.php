<?php
define('APPPATH', realpath('../'));

require_once (APPPATH . "/vendor/autoload.php");

$config = require_once (APPPATH . "/app/config/config.php");
$routes = include_once (APPPATH . "/app/config/routes.php");

$app = new Skeleton\Library\Bootstrap($routes, $config);

$app->injectDependecy([
    'view' => "\Skeleton\Service\TwigViewService",
])->addGenericMiddleware([
    '\Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware',
]);

$app->run();