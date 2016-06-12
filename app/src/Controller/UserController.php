<?php

namespace Skeleton\Controller;

use \Skeleton\Controller\AbstractSkeletonController;
use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;

class UserController extends AbstractSkeletonController
{

  public function fetch(ServerRequestInterface $request, ResponseInterface $response, $args)
  {
    $users = $this->ci->userService->get();
    $render = $response->withHeader('Content-type', 'application/json');
    $render = $response->withJson($users);

    return $render;
  }
}
