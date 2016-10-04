<?php

namespace Skeleton\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

interface SkeletonControllerInterface
{
    public function init(ServerRequestInterface $request, ResponseInterface $response, $args);
}