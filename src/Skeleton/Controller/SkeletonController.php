<?php

namespace Skeleton\Controller;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Skeleton\Exception\SkeletonException;
use Slim\Http\Response;

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
    protected $request;

    /**
     * @var ResponseInterface $response
     */
    protected $response;

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

        $calledController = get_called_class();
        $calledController = explode('\\', $calledController);
        $controllerDefaultAction = end($calledController);
        $controllerDefaultAction = strtolower(str_replace('Controller', '', $controllerDefaultAction)) . 'Action';

        if ((bool) $action) {
            $action = $this->getUrlParams('action') . 'Action';
            $this->createServiceInstance();

            if (method_exists($this, $action)) {
                $response = $this->$action();
            }
        } elseif (method_exists($this, $controllerDefaultAction)) {
            $response = $this->$controllerDefaultAction();
        } else {
            $response = $this->getResponse()->withStatus(404);
        }

        return $this->renderResponse($response);
    }

    /**
     * renderResponse
     * @return response
     * @author Renato Rodrigues de Araujo <renato.araujo@ertic.com.br>
     */
    protected function renderResponse(Response $response)
    {
        $this->setReponse($response);

        if ($this->getResponse() instanceof ResponseInterface) {
            $render = $this->getResponse();
        } else {
            $render = $this->setNotFound();
        }

        return $render;
    }

    /**
     * setNotFound
     * @return SkeletonController
     * @author Renato Rodrigues de Araujo <renato.araujo@ertic.com.br>
     */
    protected function setNotFound()
    {
        return $this->setReponse($this->getResponse()->withStatus(404));
    }

    /**
     * Create service from action name or controller name
     * @return void
     * @author Renato Rodrigues de Araujo <renato.araujo@ertic.com.br>
     */
    protected function createServiceInstance()
    {
        # try to create from action given from routes
        $serviceFromAction = ucwords($this->getUrlParams('action') . 'Service');
        $serviceFromController = str_replace('Controller', 'Service', get_called_class());

        if ($this->hasService($serviceFromAction)) {
            $this->service = $serviceFromAction;
        } elseif ($this->hasService($serviceFromController)) {
            $this->service = $serviceFromController;
        }

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

    /**
     * setUrlParams
     * @param array $params
     * @return $this
     * @author Renato Rodrigues de Araujo <renato.araujo@ertic.com.br>
     */
    protected function setUrlParams(array $params)
    {
        $this->urlParams = $params;
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

    /**
     * getResponse
     * @return response
     */
    protected function getResponse()
    {
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
     * @inheritdoc
     */
    protected function isPost()
    {
        return $this->getRequest()->isPost();
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
     * @inheritdoc
     */
    protected function isGet()
    {
        return $this->getRequest()->isGet();
    }

    /**
     * @inheritdoc
     */
    protected function isPut()
    {
        return $this->getRequest()->isPut();
    }

    /**
     * @inheritdoc
     */
    protected function isDelete()
    {
        return $this->getRequest()->isDelete();
    }

    /**
     * @inheritdoc
     */
    protected function isPatch()
    {
        return $this->getRequest()->isPatch();
    }

    /**
     * @inheritdoc
     */
    protected function isHead()
    {
        return $this->getRequest()->isHead();
    }

    /**
     * @inheritdoc
     */
    protected function isOptions()
    {
        return $this->getRequest()->isOptions();
    }

    /**
     * @inheritdoc
     */
    protected function isXhr()
    {
        return $this->getRequest()->isXhr();
    }

    /**
     * @inheritdoc
     */
    protected function getUri()
    {
        return $this->getRequest()->getUri();
    }

    /**
     * @inheritdoc
     */
    protected function getHeader($headerName)
    {
        return $this->getRequest()->getHeader($headerName);
    }

    /**
     * @inheritdoc
     */
    protected function getHeaders($headerName)
    {
        return $this->getRequest()->getHeaders($headerName);
    }

    /**
     * @inheritdoc
     */
    protected function hasHeader($headerName)
    {
        return $this->getRequest()->hasHeader($headerName);
    }

    /**
     * @inheritdoc
     */
    protected function getUploadedFiles()
    {
        return $this->getRequest()->getUploadedFiles();
    }

    /**
     * @inheritdoc
     */
    protected function getBody()
    {
        return $this->getRequest()->getBody();
    }
}
