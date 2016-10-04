<?php
namespace Skeleton\Exception;

/**
 * Class SkeletonException
 * @package Skeleton\Exception
 */
class SkeletonException extends \Exception
{

    /**
     * SkeletonException constructor.
     * @param string $message
     * @param null $code
     * @param null $previous
     */
    public function __construct($message, $code = null, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}