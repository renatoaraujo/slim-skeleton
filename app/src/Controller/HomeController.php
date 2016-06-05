<?php
namespace Skeleton\Controller;

use Skeleton\Controller\SkeletonController;
use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;

class HomeController extends SkeletonController
{

    public function testing(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $params = [];
        return $this->ci->view->render($response, 'index.html', $params);
    }
    
    public function teste(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $params = [];
        return $this->ci->view->render($response, 'teste.html', $params);
    }
}
