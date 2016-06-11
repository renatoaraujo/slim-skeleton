<?php
defined('APPPATH') || define('APPPATH', dirname(__DIR__));
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

require_once (APPPATH . "/vendor/autoload.php");

$settings = require_once (APPPATH . '/config/config.php');
$routes = include_once (APPPATH . '/config/routes.php');

$app = new \Skeleton\Library\Bootstrap($routes, $settings);

$app->injectDependecy([
    'view' => '\Skeleton\Service\TwigViewService',
    'em' => '\Skeleton\Service\DoctrineORMService',
    'logger' => '\Skeleton\Service\MonologService',
    'errorHandler' => [
        'service' => 'Skeleton\Handler\ErrorHandler',
        'dependency' => 'logger'
    ],
    'notFoundHandler' => function ($c) {
        return function ($request, $response) use ($c) {
            return $c['view']->render($response, '404.html', [])
                ->withStatus(404);
        };
    }
])
    ->addGenericMiddleware([
    '\Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware'
]);

$app->run();
