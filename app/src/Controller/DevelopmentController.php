<?php

namespace Skeleton\Controller;

use \Skeleton\Controller\AbstractSkeletonController;
use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;

final class DevelopmentController extends AbstractSkeletonController
{

    public function renderDevelopmentPage(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $this->setParams('route', 'development');
        $this->setHtmlFile('development');
        return $this->render($response);
    }

}