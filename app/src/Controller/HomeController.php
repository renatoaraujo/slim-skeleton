<?php
namespace Skeleton\Controller;

use \Skeleton\Controller\AbstractSkeletonController;
use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;

class HomeController extends AbstractSkeletonController
{
    public function renderHomePage(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $this->setParams('route', 'home');
        $this->setHtmlFile('index');
        return $this->render($response);
    }
}
