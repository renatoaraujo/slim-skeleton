<?php

use \Slim\Container;
use \Slim\App;
use \Slim\Views\Twig;
use \Slim\Views\TwigExtension;

define('APPPATH', realpath('../'));
require_once (APPPATH . "/vendor/autoload.php");
$config = require_once (APPPATH . "/src/config/config.php");

$app = new App($config);
$container = $app->getContainer();

// ##
// CREATE YOUR CUSTOM VARIABLES TO CALL ON ROUTES
// ##
$container['view'] = function ($c) {
    $view = new Twig(APPPATH . '/src/views', [
        // 'cache' => APPPATH . '/cache'
        'cache' => false
    ]);
    $view->addExtension(new TwigExtension($c['router'], $c['request']->getUri()));
    return $view;
};

// ##
// INCLUDE DE ROUTES FILE AND RUN THE APPLICATION
// ##
$routes = include_once (APPPATH . "/src/config/routes.php");

if (is_array($routes) && ! empty($routes)) {
    foreach ($routes as $name => $route) {
        if (isset($route['middleware']) && ! empty($route['middleware'])) {
            $app->add($route['middleware']);
        }
        $app->$route['method']($route['url'], "{$route['callback']['controller']}:{$route['callback']['function']}")
            ->setName($name);
    }
}

$app->run();
