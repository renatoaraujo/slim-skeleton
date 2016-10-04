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
     * getArg
     * @param $arg
     * @return mixed
     */
    public function getArg($arg)
    {
        if (!empty($this->args)) {
            return $this->args[$arg];
        } else {
            return false;
        }
    }

    /**
     * Args
     * @param args $args
     */
    public function setArgs($args)
    {
        $this->args = $args;
        return $this;
    }

    /**
     * init
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     * @return void
     */
    public function init(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $this->setRequest($request);
        $this->setReponse($response);
        $this->setArgs($args);

        if($this->getArg('method')) {
            $method = $this->getArg('method') . 'Action';
            if(method_exists($this, $method)) {
                $this->$method();
            } else {
                return $this->getResponse()->withStatus(404);
            }
        } else {
            $this->defaultAction();
        }

    }
}
