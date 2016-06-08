<?php
namespace Skeleton\Handler;

use \Slim\Handlers\Error;
use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Message\ResponseInterface;
use \Monolog\Logger;
use \Exception;

final class ErrorHandler extends Error
{

    protected $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, Exception $exception)
    {
        $this->logger->critical($exception->getMessage());
        
        return parent::__invoke($request, $response, $exception);
    }
}