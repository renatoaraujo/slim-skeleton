<?php

namespace App;

use \Slim\Container;
use \Slim\App;
use \Slim\Views\Twig;
use \Slim\Views\TwigExtension;

define ('APPPATH', realpath('../'));

require_once(APPPATH . "/app/config/config.php");
require_once(APPPATH . "/app/config/autoload.php");
require_once(APPPATH . "/vendor/autoload.php");

$container = new Container;

$container['view'] = function ($c) {
    $view = new Twig(APPPATH . '/app/assets/templates', [
        'cache' => APPPATH . '/app/cache'
        // 'cache' => false
    ]);
    $view->addExtension(new TwigExtension(
        $c['router'],
        $c['request']->getUri()
    ));

    return $view;
};

$app = new App($container);

require_once(APPPATH . "/app/config/router.php");

$app->run();
