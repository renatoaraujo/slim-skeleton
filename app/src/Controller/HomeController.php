<?php
namespace Skeleton\Controller;

use Skeleton\Controller\AbstractSkeletonController;
use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;

class HomeController extends AbstractSkeletonController
{

    public function testing(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $params = [];
        return $this->ci->view->render($response, 'index.html', $params);
    }
}
