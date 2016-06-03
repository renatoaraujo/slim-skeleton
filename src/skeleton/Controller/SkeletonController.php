<?php
namespace Skeleton\Controller;

use Interop\Container\ContainerInterface;

class SkeletonController
{

    protected $ci;

    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
    }
}