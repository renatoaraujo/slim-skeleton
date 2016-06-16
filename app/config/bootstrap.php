<?php
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));
defined('APPPATH') || define('APPPATH', dirname(__DIR__));
defined('ROOTPATH') || define('ROOTPATH', dirname(APPPATH));

require_once(ROOTPATH . "/vendor/autoload.php");

$settings = require_once(APPPATH . '/config/config.php');
$routes = require_once(APPPATH . '/config/routes.php');

$app = new \Skeleton\Library\Bootstrap($routes, $settings);

$app->injectDependecy([
    'view' => '\Skeleton\Service\TwigViewService',
    'em' => '\Skeleton\Service\DoctrineORMService',
    'logger' => '\Skeleton\Service\MonologService',
    'userService' => [
        'service' => '\Skeleton\Service\UserService',
        'dependency' => 'em',
    ],
    'errorHandler' => function ($c) {
        return function ($request, $response, $exception) use ($c) {
            $c['logger']->critical($exception->getMessage());
            $params = [
                'error' => $exception->getMessage(),
                'status' => [
                    'code' => '500',
                    'error' => 'Internal Server Error',
                    'message' => 'message',
                    'icon' => 'server'
                ]
            ];
            return $c['view']->render($response, 'error.html', $params)
                ->withStatus(500);
        };
    },
    'notFoundHandler' => function ($c) {
        return function ($request, $response) use ($c) {
            $params = [
                'status' => [
                    'code' => '404',
                    'error' => 'Page Not Found',
                    'message' => 'The page you requested does not exist or were moved to another URL.',
                    'icon' => 'map-signs',
                ]
            ];
            return $c['view']->render($response, 'error.html', $params)
                ->withStatus(404);
        };
    },
    'notAllowedHandler' => function ($c) {
        return function ($request, $response, $methods) use ($c) {
            $params = [
                'status' => [
                    'code' => '405',
                    'error' => 'Method Not Allowed',
                    'message' => 'Method must be one of: ' . implode(', ', $methods),
                    'icon' => 'gears'
                ]
            ];
            return $c['view']->render($response, 'error.html', $params)
                ->withHeader('Allow', implode(', ', $methods))
                ->withStatus(405);
        };
    },
]);

return $app;
