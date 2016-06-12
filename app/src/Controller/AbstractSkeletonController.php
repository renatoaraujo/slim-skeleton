<?php
namespace Skeleton\Controller;

use Interop\Container\ContainerInterface;

abstract class AbstractSkeletonController
{

    protected $ci;

    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
    }
}
