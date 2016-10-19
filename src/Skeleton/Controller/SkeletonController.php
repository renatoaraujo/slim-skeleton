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
    protected $ci;

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
    public function getUrlParams($param = null)
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

    public function setUrlParams(array $params)
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

        $method = $this->getUrlParams('method');

        if ((bool) $method) {
            $method = $this->getUrlParams('method') . 'Action';
            if (method_exists($this, $method)) {
                $called = $this->$method();

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
}
