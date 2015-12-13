<?php

define ('APPPATH', realpath('../'));

include_once APPPATH . "/app/config/config.php";
include_once APPPATH . "/app/config/autoload.php";
include_once APPPATH . "/vendor/autoload.php";

$container = new \Slim\Container;

$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig(APPPATH . '/app/assets/templates', [
        // 'cache' => APPPATH . '/app/cache'
        'cache' => false
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $c['router'],
        $c['request']->getUri()
    ));

    return $view;
};

$app = new \Slim\App($container);

include_once APPPATH . "/app/config/router.php";

$app->run();
