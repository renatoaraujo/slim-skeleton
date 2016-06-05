<?php
namespace Skeleton\Middleware;

use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;

class HomeMiddleware
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        $response->getBody()->write('BEFORE');
        $response = $next($request, $response);
        $response->getBody()->write('AFTER');
        
        return $response;
    }
}