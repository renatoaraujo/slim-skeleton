<?php
namespace Skeleton\Exception;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class SkeletonException extends \Exception
{
    
    public function __construct($message, $code = null, $previous = null){
        parent::__construct($message, $code, $previous);
    }
    
    /**
     * Method to save the log
     */
    protected function save()
    {
        
    }
    
    /**
     * Method to send the exception email
     */
    protected function send()
    {
        
    }
    
}