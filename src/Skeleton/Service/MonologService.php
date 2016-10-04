<?php
namespace Skeleton\Service;

use Interop\Container\ContainerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Handler\FingersCrossedHandler;

class MonologService
{

    public function __invoke(ContainerInterface $ci)
    {
        $settings = $ci->get('settings');
        $logger = new Logger('logger');

        $stream = new StreamHandler($settings['monolog']['log_error'], Logger::DEBUG);
        $fingersCrossed = new FingersCrossedHandler($stream, Logger::ERROR);
        $logger->pushHandler($fingersCrossed);

        return $logger;
    }
}
