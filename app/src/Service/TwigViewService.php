<?php
namespace Skeleton\Service;

use \Slim\Views\Twig;
use \Slim\Views\TwigExtension;
use \Interop\Container\ContainerInterface;

class TwigViewService
{

    public function __invoke(ContainerInterface $ci)
    {
        $settings = $ci->get('settings');
        $view = new Twig($settings['twig']['view_path'], $settings['twig']['settings']);
        $view->addExtension(new TwigExtension($ci['router'], $ci['request']->getUri()));
        return $view;
    }
}