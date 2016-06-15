<?php

namespace Skeleton\Controller;

use \Skeleton\Controller\AbstractSkeletonController;
use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;


/**
 * Class SigninController
 * @package Skeleton\Controller
 */
class SigninController extends AbstractSkeletonController
{

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     * @return mixed
     */
    public function renderSigninPage(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $this->setParams('route', 'signin');
        $this->setHtmlFile('signin');
        return $this->render($response);
    }
}