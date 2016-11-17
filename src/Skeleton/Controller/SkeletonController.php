<?php

namespace Skeleton\Controller;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Skeleton\Exception\SkeletonException;

/**
 * Skeleton Controller
 * @package Skeleton\Controller
 * @author Renato Rodrigues de Araujo <renato.r.araujo@gmail.com>
 */
abstract class SkeletonController implements SkeletonControllerInterface
{

    /**
     * @var ContainerInterface
     */
    private $ci;

    /**
     * @var ServerRequestInterface $request
     */
    private $request;

    /**
     * @var ResponseInterface $response
     */
    private $response;

    /**
     * @var $urlParams
     */
    protected $urlParams;

    /**
     * @var service
     */
    protected $service;

    /**
     * AbstractSkeletonController constructor.
     * @param ContainerInterface $ci
     */
    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
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
     * getUrlParams
     * @param null $param
     * @return bool
     */
    protected function getUrlParams($param = null)
    {
        $return = false;

        if (!is_null($param)) {
            if (!empty($this->urlParams)) {
                $return = isset($this->urlParams[$param]) ? $this->urlParams[$param] : false;
            }
        } else {
            $return = $this->urlParams;
        }

        return $return;
    }

    protected function setUrlParams(array $params)
    {
        $this->urlParams = $params;
        return $this;
    }

    /**
     * init
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $urlParams
     * @return ResponseInterface
     * @throws SkeletonException
     */
    public function init(ServerRequestInterface $request, ResponseInterface $response, $urlParams)
    {
        $this->setRequest($request);
        $this->setReponse($response);
        $this->setUrlParams($urlParams);

        $action = $this->getUrlParams('action');

        if ((bool) $action) {
            $action = $this->getUrlParams('action') . 'Action';
            $service = $this->getUrlParams('action') . '.service';

            if ($this->hasService($service)) {
                $this->service = $service;
            }

            if (method_exists($this, $action)) {
                $called = $this->$action();

                if (!$called instanceof ResponseInterface) {
                    throw new SkeletonException('The method MUST resturn ResponseInteface instance');
                }

            } else {
                $this->response = $this->getResponse()->withStatus(404);
            }
        } else {
            $this->defaultAction();
        }

        return $this->response;
    }

    /**
     * Method to get service. Just an alias for ContainerInterface::get()
     * @param null $service
     * @return mixed|null|service
     * @throws SkeletonException
     * @throws \Interop\Container\Exception\ContainerException
     * @throws \Interop\Container\Exception\NotFoundException
     */
    protected function getService($service = null)
    {
        if (is_null($service)) {
            $service = $this->service;
        }

        if (!$this->hasService($service)) {
            throw new SkeletonException('Error: Unavailable service. ' . $service);
        }

        $service = $this->ci->get($service);

        return $service;
    }

    /**
     * Method to set the default service for controller
     * @param $service
     * @return $this
     */
    protected function setService($service)
    {
        $this->service = $service;
        return $this;
    }

    /**
     * Method to check if has the service. Just an alias for ContainerInterface::has()
     * @param $service
     * @return mixed
     * @throws \Interop\Container\Exception\ContainerException
     * @throws \Interop\Container\Exception\NotFoundException
     */
    protected function hasService($service)
    {
        try {
            $this->ci->get($service);
            $hasService = true;
        } catch (\Slim\Exception\ContainerValueNotFoundException $exception) {
            $hasService = false;
        }

        return $hasService;
    }
}
