<?php

namespace Skeleton\Controller;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class SkeletonController
 * @package Skeleton\Controller
 */
abstract class SkeletonController implements SkeletonControllerInterface
{

    /**
     * @var ContainerInterface
     */
    protected $ci;

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var  request
     */
    protected $request;

    /**
     * @var  response
     */
    protected $response;

    /**
     * @var  args
     */
    protected $args;

    /**
     * AbstractSkeletonController constructor.
     * @param ContainerInterface $ci
     */
    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
    }

    /**
     *
     * @param string|int $key
     * @param mixed $value
     */
    public function setParams($key, $value)
    {
        $this->params[$key] = $value;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * setRequest
     * @param $request
     * @return $this
     */
    protected function setRequest(ServerRequestInterface $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * setReponse
     * @param $response
     * @return $this
     */
    protected function setReponse(ResponseInterface $response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * getRequest
     * @return request
     */
    protected function getRequest()
    {
        return $this->request;
    }

    /**
     * getResponse
     * @return response
     */
    protected function getResponse()
    {
        return $this->response;
    }

    /**
     * Args
     * @return args
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * Args
     * @param args $args
     */
    public function setArgs($args)
    {
        $this->args = $args;
    }
}
