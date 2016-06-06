<?php
namespace Skeleton\Service;

use \Slim\Views\Twig;
use \Slim\Views\TwigExtension;
use \Interop\Container\ContainerInterface;
use Skeleton;

class TwigViewService
{

    public function __invoke(ContainerInterface $ci)
    {
        $view = new Twig(APPPATH . '/app/views', [
            'cache' => APPPATH . '/cache',
            'auto_reload' => true,
        ]);
        
        $view->addExtension(new TwigExtension($ci['router'], $ci['request']->getUri()));
        return $view;
    }
}