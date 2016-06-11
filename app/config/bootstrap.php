<?php
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));
defined('APPPATH') || define('APPPATH', dirname(__DIR__));
defined('ROOTPATH') || define('ROOTPATH', dirname(APPPATH));

require_once (ROOTPATH . "/vendor/autoload.php");

$settings = require_once (ROOTPATH . '/app/config/config.php');
$routes = require_once (ROOTPATH . '/app/config/routes.php');

$app = new \Skeleton\Library\Bootstrap($routes, $settings);

$app->injectDependecy([
    'view' => '\Skeleton\Service\TwigViewService',
    'em' => '\Skeleton\Service\DoctrineORMService',
    'logger' => '\Skeleton\Service\MonologService',
    // 'errorHandler' => [
    // 'service' => '\Skeleton\Handler\ErrorHandler',
    // 'dependency' => 'logger'
    // ],
    'notFoundHandler' => function ($c) {
        return function ($request, $response) use ($c) {
            return $c['view']->render($response, '404.html', [])
                ->withStatus(404);
        };
    }
]);

if (APPLICATION_ENV === 'development' || APPLICATION_ENV === 'testing') {
    $app->addGenericMiddleware([
        '\Zeuxisoo\Whoops\Provider\Slim\WhoopsMiddleware'
    ]);
}

return $app;
