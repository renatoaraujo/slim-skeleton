<?php
namespace Skeleton\Controller;

use \Interop\Container\ContainerInterface;
use \Psr\Http\Message\ResponseInterface;

/**
 * Class AbstractSkeletonController
 * @package Skeleton\Controller
 */
abstract class AbstractSkeletonController
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
     * @var
     */
    protected $htmlFile;

    /**
     * AbstractSkeletonController constructor.
     * @param ContainerInterface $ci
     */
    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;
    }


    /**
     * @param $key
     * @param $value
     */
    final public function setParams($key, $value)
    {
        $this->params[$key] = $value;
    }

    /**
     * @return array
     */
    final public function getParams()
    {
        return $this->params;
    }

    /**
     * @param $htmlFile
     */
    final public function setHtmlFile($htmlFile)
    {
        $this->htmlFile = $htmlFile . ".html";
    }

    /**
     * @return mixed
     */
    final public function getHtmlFile()
    {
        return $this->htmlFile;
    }

    /**
     * @param ResponseInterface $response
     * @return mixed
     */
    public function render(ResponseInterface $response)
    {
        return $this->ci->view->render($response, $this->getHtmlFile(), $this->getParams());
    }

}
