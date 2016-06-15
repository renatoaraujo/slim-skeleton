<?php

namespace Skeleton\Controller;

use \Skeleton\Controller\AbstractSkeletonController;
use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;

/**
 * Class UserController
 * @package Skeleton\Controller
 */
class UserController extends AbstractSkeletonController
{

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     * @return static
     */
    public function fetch(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $users = $this->ci->userService->get();
        $render = $response->withHeader('Content-type', 'application/json');
        $render = $response->withJson($users);

        return $render;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     * @return static
     */
    public function fetchOne(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $user = $this->ci->userService->get($args['pubUniqueId']);
        $render = $response->withHeader('Content-type', 'application/json');
        $render = $response->withJson($user);

        return $render;
    }
}
