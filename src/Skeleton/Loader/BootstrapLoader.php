<?php
namespace Skeleton\Loader;

use Slim\App;
use Skeleton\Exception\SkeletonException;
use Skeleton\Constants\SkeletonExceptionConstants as e;

/**
 * Class BootstrapLoader
 * @package Skeleton\Loader
 * @author Renato Rodrigues de Araujo <renato.r.araujo@gmail.com>
 * @todo implement better group routing
 */
class BootstrapLoader extends App
{
    /**
     * @var \Interop\Container\ContainerInterface container
     */
    protected $container;

    /**
     * @var array _routes
     */
    protected $_routes;

    /**
     * BootstrapLoader constructor.
     * @param array $routes
     * @param null $options
     */
    public function __construct(array $routes, $options = null)
    {
        parent::__construct($options);
        $this->container = $this->getContainer();
        $this->_routes = $routes;
        $this->resolve();
    }

    /**
     * resolve
     * @return void
     * @author Renato Rodrigues de Araujo <renato.r.araujo@gmail.com>
     */
    protected function resolve()
    {
        foreach ($this->_routes as $name => $route) {
            $arr_route = $this->validateRoute($name, $route);

            if (isset($arr_route['middleware']) && !empty($arr_route['middleware'])) {
                $this->$arr_route['method']($arr_route['url'], "{$arr_route['callback']}")
                    ->add($arr_route['middleware'])
                    ->setName($name);
            } else {
                $method = $arr_route['method'];
                $this->$method($arr_route['url'], "{$arr_route['callback']}")->setName($name);
            }
        }
    }

    /**
     * Method to validate the routes
     * @param $name
     * @param $route
     * @return array
     * @throws SkeletonException
     * @author Renato Rodrigues de Araujo <renato.r.araujo@gmail.com>
     */
    protected function validateRoute($name, $route)
    {
        $arr_route = [];

        if (!array_key_exists('method', $route)) {
            $route['method'] = 'any';
        }

        $arr_route['method'] = $method = $route['method'];

        if ($method && $method != 'group') {
            if (!array_key_exists('url', $route)) {
                throw new SkeletonException(
                    sprintf(e::ERR_MISSING_URL_ROUTE_MSG, $name),
                    e::ERR_MISSING_URL_ROUTE_CODE
                );
            }

            if (!array_key_exists('callback', $route)) {
                throw new SkeletonException(
                    sprintf(e::ERR_MISSING_CALLBACK_ROUTE_MSG, $name),
                    e::ERR_MISSING_CALLBACK_ROUTE_CODE
                );
            }

            $arr_route['url'] = $url = $route['url'];
            $arr_route['callback'] = $this->validateCallback($route['callback'], $name);
        }

        if (array_key_exists('middleware', $route)) {
            $arr_route['middleware'] = $this->validateCallable(new $route['middleware']());
        }

        return $arr_route;
    }

    /**
     * validateCallback
     * @param $callback
     * @param $name
     * @return string
     * @throws SkeletonException
     * @author Renato Rodrigues de Araujo <renato.r.araujo@gmail.com>
     */
    protected function validateCallback($callback, $name)
    {
        if (!$callback && !(is_string($callback) && emtpy($callback))) {
            throw new SkeletonException("Error: Callback need to be declared in route {$name}");
        }

        if (!array_key_exists('controller', $callback)) {
            throw new SkeletonException("Error: You need to declare the controller in route {$name}");
        }

        if (!array_key_exists('function', $callback)) {
            $callback['function'] = 'init';
        }

        if (!array_key_exists('action', $callback)) {
            $callback['function'] = 'init';
        } elseif (array_key_exists('action', $callback)) {
            $callback['function'] = $callback['action'];
        }

        $controller = $callback['controller'];
        $function = $callback['function'];

        if (!is_string($controller) && !is_string($function)) {
            throw new SkeletonException("Error you need to use string to declare your callback in route {$name}");
        }

        if (!class_exists($controller)) {
            throw new SkeletonException("Error: callback class not existent in route {$name}");
        }

        if (!method_exists($controller, $function)) {
            throw new SkeletonException("Error: method {$function} inexistent in route {$name}");
        }

        $callback = "{$controller}:{$function}";

        return $callback;
    }

    /**
     * validateCallable
     * @param $object
     * @return mixed
     * @throws SkeletonException
     * @author Renato Rodrigues de Araujo <renato.r.araujo@gmail.com>
     */
    protected function validateCallable($object)
    {
        $class_name = get_class($object);

        if (!is_callable($object) && !class_exists($class_name)) {
            throw new SkeletonException("Error: The object does not exist or is not callable \"{$class_name}\"");
        }

        return $object;
    }

    /**
     * injectDependecy
     * @param array $dependencies
     * @return $this
     * @throws SkeletonException
     * @author Renato Rodrigues de Araujo <renato.r.araujo@gmail.com>
     */
    public function injectDependecy(array $dependencies)
    {
        if (!empty($dependencies)) {
            foreach ($dependencies as $name => $object) {
                if (is_array($object) && !empty($object)) {
                    if (isset($object['object'])) {
                        $dependencyObject = $object['object'];
                    }

                    $constructorArgs = [];

                    if (isset($object['arguments'])) {
                        $dependencyObjectArguments = $object['arguments'];

                        if (is_array($dependencyObjectArguments)) {
                            foreach ($dependencyObjectArguments as $nameIndex => $argument) {
                                if (gettype($argument) == 'string') {
                                    $isObjectSettedOnContainer = $this->container->has($argument);

                                    if ($isObjectSettedOnContainer) {
                                        $constructorArgs[$nameIndex] = $this->container[$argument];
                                        continue;
                                    }
                                }

                                $constructorArgs[$nameIndex] = $argument;
                            }
                        } else {
                            if (gettype($dependencyObjectArguments) == 'string') {
                                $constructorArgs = [$dependencyObjectArguments];

                                $isObjectSettedOnContainer = $this->container->has($dependencyObjectArguments);

                                if ($isObjectSettedOnContainer) {
                                    $constructorArgs = [
                                        $this->container[$dependencyObjectArguments]
                                    ];
                                }
                            }
                        }
                    }

                    $object = $this->validateCallable(new $dependencyObject(...array_values($constructorArgs)));
                } else {
                    if (gettype($object) == 'string') {
                        $object = $this->validateCallable(new $object());
                    } else {
                        if (!(gettype($object) == 'object' && $object instanceof \Closure)) {
                            throw new SkeletonException(
                                e::ERR_OBJ_AS_STRING_OR_ANON_MSG,
                                e::ERR_OBJ_AS_STRING_OR_ANON_CODE
                            );
                        }
                    }
                }

                $this->container[$name] = $object;
            }
        }

        return $this;
    }

    /**
     * addGenericMiddleware
     * @return $this
     * @throws SkeletonException
     * @author Renato Rodrigues de Araujo <renato.r.araujo@gmail.com>
     */
    public function addGenericMiddleware()
    {
        $arguments = func_get_args();
        $middlewares = $arguments[0];
        $paramsForMiddleWare = $arguments[1];

        if (!is_array($paramsForMiddleWare) && !empty($paramsForMiddleWare)) {
            throw new SkeletonException('Error: The optional parameters need to be used as array.');
        }

        if (is_array($middlewares) && !empty($middlewares)) {
            throw new SkeletonException('Error: The middleware need to be used as array.');
        } elseif (!empty($middlewares) && !is_array($middlewares)) {
            $reflect = new \ReflectionClass($middlewares);
            $middleware = $this->validateCallable($reflect->newInstanceArgs($paramsForMiddleWare));
            $this->add($middleware);
        }

        return $this;
    }
}
