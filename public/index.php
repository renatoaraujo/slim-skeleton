<?php

use \Slim\Views\Twig;
use \Slim\Views\TwigExtension;

define('APPPATH', realpath('../'));
require_once (APPPATH . "/vendor/autoload.php");
$config = require_once (APPPATH . "/src/config/config.php");
$routes = include_once (APPPATH . "/src/config/routes.php");

$app = new Skeleton\Library\Bootstrap($routes, $config);

$app->injectDependecy('view', function ($c) {
    $view = new Twig(APPPATH . '/src/views', [
        // 'cache' => APPPATH . '/cache'
        'cache' => false
    ]);
    $view->addExtension(new TwigExtension($c['router'], $c['request']->getUri()));
    return $view;
});

$app->run();

// $debg = new \Skeleton\Library\Debug();
// $debg->setLogPath('debug');
// $debg->setLogPath(APPPATH . "/logs/debug.log");
// $debg->setJsonFormat(false);
// $debg->displayScreen();