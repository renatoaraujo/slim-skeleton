<?php
namespace Skeleton\Utils;

use Slim\App;
use Skeleton\Exception\SkeletonException;

/**
 * Object to bootstrap the application
 *
 * @author Renato Rodrigues de Araujo <renato.r.araujo@gmail.com>
 */
class Bootstrap extends App
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
     *
     * @param array $routes
     * @param unknown $options
     */
    public function __construct(array $routes, $options = null)
    {
        parent::__construct($options);
        $this->container = $this->getContainer();

        $this->_routes = $routes;
        $this->resolve();
    }

    /**
     * Method to inject the dependencies services on application bootstrap
     *
     * @param array $dependencies
     *            dependencies declared like [name=>service]
     * @return Bootstrap instance
     * @throws SkeletonException
     */
    public function injectDependecy(array $dependencies)
    {
        if (is_array($dependencies) && !empty($dependencies)) {
            foreach ($dependencies as $name => $service) {

                if (is_array($service) && !empty($service)) {
                    $dependency = $service['dependency'];
                    $service = $service['service'];
                    $service = $this->validateCallable(new $service($this->container[$dependency]));
                } else {
                    if (gettype($service) == 'string') {
                        $service = $this->validateCallable(new $service());
                    } else {
                        if (!(gettype($service) == 'object' && $service instanceof \Closure)) {
                            throw new SkeletonException("Error: Use only Object as string or Anonymous functions.");
                        }
                    }
                }

                $this->container[$name] = $service;
            }
        }

        return $this;
    }

    /**
     * validateDependencyName
     * @param $name
     * @return mixed
     * @throws SkeletonException
     */
    protected function validateDependencyName($name)
    {
        $allowedChars = "/^[a-zA-Z]+$/";

        if (!preg_match($allowedChars, $name)) {
            throw new SkeletonException("Error: Use a simple string without special characters or numbers to name your service. \"{$name}\"");
        }

        return $name;
    }

    /**
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
     * validateRoute
     * @param $name
     * @param $route
     * @return array
     * @throws SkeletonException
     */
    protected function validateRoute($name, $route)
    {
        $arr_route = [];

        if (!array_key_exists('method', $route)) {
            throw new SkeletonException("Error: You need to declare the HTTP method in route {$name}");
        }

        $arr_route['method'] = $method = $route['method'];

        if ($method && $method != 'group') {
            if (!array_key_exists('url', $route)) {
                throw new SkeletonException("Error: Please specify the URL in route {$name}");
            }

            if (!array_key_exists('callback', $route)) {
                throw new SkeletonException("Error: you need to declare the callback in route {$name}");
            }

            $arr_route['url'] = $url = $route['url'];
            $arr_route['callback'] = $this->validateCallback($route['callback'], $name);
        } else {
            if (!array_key_exists('group', $route)) {
                throw new SkeletonException(
                    "Error: You need to declare the group in array to use this HTTP method {$name}"
                );
            }

            $group = $route['group'];

            if ($group && (is_array($group) && !empty($group))) {
                foreach ($group as $key => $value) {
                    if (!array_key_exists('url', $value)) {
                        throw new SkeletonException("Please specify the URL in group {$key} in route {$name}");
                    }

                    if (!array_key_exists('callback', $value)) {
                        throw new SkeletonException(
                            "Error: you need to declare the callback in group {$value['key']} in route {$name}"
                        );
                    }

                    $url = $value['url'];
                    $this->validateCallback($value['callback'], $name);
                }
            }
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
     */
    protected function validateCallback($callback, $name)
    {
        if (!$callback && !(is_string($callback) && emtpy($callback))) {
            throw new SkeletonException("Error: callback need to be declared in route {$name}");
        }

        if (!array_key_exists('controller', $callback)) {
            throw new SkeletonException("Error: you need to declare the controller in route {$name}");
        }

        if (!array_key_exists('function', $callback)) {
            throw new SkeletonException(
                "Error: you need to declare the function in route {$name} or use the callback as string."
            );
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
     * addGenericMiddleware
     * @param array $middlewares
     * @return $this
     */
    public function addGenericMiddleware(array $middlewares)
    {
        if (is_array($middlewares) && !empty($middlewares)) {
            foreach ($middlewares as $middleware) {
                $middleware = $this->validateCallable(new $middleware());
                $this->add($middleware);
            }
        }
        return $this;
    }

    /**
     * validateCallable
     * @param $object
     * @return mixed
     * @throws SkeletonException
     */
    protected function validateCallable($object)
    {
        $class_name = get_class($object);

        if (!is_callable($object) && !class_exists($class_name)) {
            throw new SkeletonException("Error: The object does not exist or is not callable \"{$class_name}\"");
        }

        return $object;
    }
}
