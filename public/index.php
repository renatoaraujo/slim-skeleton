<?php

use \Slim\Container;
use \Slim\App;
use \Slim\Views\Twig;
use \Slim\Views\TwigExtension;

define ('APPPATH', realpath('../'));

require_once(APPPATH . "/src/config/config.php");
require_once(APPPATH . "/src/config/autoload.php");
require_once(APPPATH . "/vendor/autoload.php");

$container = new Container;

$container['view'] = function ($c) {
    $view = new Twig(APPPATH . '/public/assets/templates', [
        // 'cache' => APPPATH . '/cache'
        'cache' => false
    ]);
    $view->addExtension(new TwigExtension(
        $c['router'],
        $c['request']->getUri()
    ));

    return $view;
};

$app = new App($container);

require_once(APPPATH . "/src/config/router.php");

$app->run();
