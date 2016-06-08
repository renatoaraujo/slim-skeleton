<?php
namespace Skeleton\Handler;

use \Slim\Handlers\Error;
use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;
use \Monolog\Logger;
use \Exception;

final class ApiErrorHandler extends Error
{

    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Exception $exception)
    {
        $this->logger->critical($exception->getMessage());
        
        $body = json_encode([
            'error' => $exception->getMessage(),
            'code' => $exception->getCode()
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        
        return $response->withStatus(500)
            ->withHeader('Content-type', 'application/json')
            ->withBody(new Body(fopen('php://temp', 'r+')))
            ->write($body);
    }
}