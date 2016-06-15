<?php
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));
defined('APPPATH') || define('APPPATH', dirname(__DIR__));
defined('ROOTPATH') || define('ROOTPATH', dirname(APPPATH));

require_once (ROOTPATH . "/vendor/autoload.php");

$settings = require_once (APPPATH . '/config/config.php');
$routes = require_once (APPPATH . '/config/routes.php');

$app = new \Skeleton\Library\Bootstrap($routes, $settings);

$app->injectDependecy([
  'view' => '\Skeleton\Service\TwigViewService',
  'em' => '\Skeleton\Service\DoctrineORMService',
  'logger' => '\Skeleton\Service\MonologService',
  'userService' => [
    'service' => '\Skeleton\Service\UserService',
    'dependency' => 'em',
  ],
  'errorHandler' => function($c) {
    return function ($request, $response, $exception) use ($c) {

      $c['logger']->critical($exception->getMessage());

      $params = [];

      if (APPLICATION_ENV === 'development' || APPLICATION_ENV === 'testing') {
        $params = [
          'error' => $exception->getMessage(),
          'status' => '500 Internal server error'
        ];
      }

      return $c['view']->render($response, '500.html', $params)
      ->withStatus(500);
    };
  },
  'notFoundHandler' => function ($c) {
    return function ($request, $response) use ($c) {
      $params = [
        'status' => '404 not found',
      ];
      return $c['view']->render($response, '404.html', $params)
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
