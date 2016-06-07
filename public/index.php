<?php
define('APPPATH', realpath('../'));
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

require_once (APPPATH . "/vendor/autoload.php");

$settings = require_once (APPPATH . "/config/config.php");
$routes = include_once (APPPATH . "/config/routes.php");

$app = new Skeleton\Library\Bootstrap($routes, $settings);

$app->injectDependecy([
    'view' => "\Skeleton\Service\TwigViewService",
    'em' => "\Skeleton\Service\DoctrineORMService",
])->addGenericMiddleware([
    '\Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware',
]);

$app->run();