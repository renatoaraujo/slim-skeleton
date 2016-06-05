<?php
namespace Skeleton\Library;

use \Slim\Container;
use \Slim\App;

/**
 * Object to bootstrap the application
 * 
 * @todo PHPDOC of the methods and refactoring of the code to make it understandable
 * 
 * @author Renato Rodrigues de Araujo <renato.r.araujo@gmail.com>
 * 
 * @version 1.0.0
 */
class Bootstrap extends App
{

    protected $container;

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
     * 
     * @param unknown $name
     * @param unknown $dependency
     */
    public function injectDependecy($name, $dependency)
    {
        $this->container[$name] = $dependency;
    }

    /**
     * 
     */
    protected function resolve()
    {
        foreach ($this->_routes as $name => $route) {
            
            $arr_route = $this->validateRoute($name, $route);
            
            if (isset($arr_route['middleware']) && ! empty($arr_route['middleware'])) {
                $this->$arr_route['method']($arr_route['url'], "{$arr_route['callback']}")->add($arr_route['middleware'])->setName($name);
            } else {
                $this->$arr_route['method']($arr_route['url'], "{$arr_route['callback']}")->setName($name);
            }
        }
    }

    /**
     * 
     * @param unknown $name
     * @param unknown $route
     * @throws \Exception
     */
    protected function validateRoute($name, $route)
    {
        $arr_route = [];
        
        if (array_key_exists('method', $route)) {
            $arr_route['method'] = $method = $route['method'];
        } else {
            throw new \Exception("Error: You need to declare the HTTP method in route {$name}");
        }
        
        if ($method && $method != 'group') {
            if (array_key_exists('url', $route)) {
                $arr_route['url'] = $url = $route['url'];
            } else {
                throw new \Exception("Error: Please specify the URL in route {$name}");
            }
            
            if (array_key_exists('callback', $route)) {
                $arr_route['callback'] = $this->validateCallback($route['callback'], $name);
            } else {
                throw new \Exception("Error: you need to declare the callback in route {$name}");
            }
        } else {
            if (array_key_exists('group', $route)) {
                $group = $route['group'];
            } else {
                throw new \Exception("Error: You need to declare the group in array to use this HTTP method {$name}");
            }
            
            if ($group && (is_array($group) && ! empty($group))) {
                foreach ($group as $key => $value) {
                    if (array_key_exists('url', $g)) {
                        $url = $g['url'];
                    } else {
                        throw new \Exception("Please specify the URL in group {$key} in route {$name}");
                    }
                    
                    if (array_key_exists('callback', $g)) {
                        $this->validateCallback($g['callback'], $name);
                    } else {
                        throw new \Exception("Error: you need to declare the callback in group {$g['key']} in route {$name}");
                    }
                }
            }
        }
        
        if (array_key_exists('middleware', $route)) {
            $arr_route['middleware'] = $this->validateMiddleware($route['middleware']);
        }
        
        return $arr_route;
    }

    /**
     * 
     * @param unknown $callback
     * @param unknown $name
     * @throws \Exception
     */
    protected function validateCallback($callback, $name)
    {
        if ($callback && (is_array($callback) && ! empty($callback))) {
            
            if (array_key_exists('controller', $callback)) {
                $controller = $callback['controller'];
            } else {
                throw new \Exception("Error: you need to declare the controller in route {$name}");
            }
            
            if (array_key_exists('function', $callback)) {
                $function = $callback['function'];
            } else {
                throw new \Exception("Error: you need to declare the function in route {$name} or use the callback as string.");
            }
            
            if (is_string($controller) && is_string($function)) {
                if (class_exists($controller)) {
                    if (method_exists($controller, $function)) {
                        $callback = "{$controller}:{$function}";
                    } else {
                        throw new \Exception("Error: method {$function} inexistent in route {$name}");
                    }
                } else {
                    throw new \Exception("Error: callback class not existent in route {$name}");
                }
            } else {
                throw new \Exception("Error you need to use string to declare your callback in route {$name}");
            }
        } else {
            if ($callback && (is_string($callback) && ! emtpy($callback))) {
                if (! class_exists($callback)) {
                    throw new \Exception("Error: callback class not existent in route {$name}");
                }
            } else {
                throw new \Exception("Error: callback need to be declared in route {$name}");
            }
        }
        
        return $callback;
    }

    /**
     * Method to validate Middleware
     * @param mixed $middleware
     * @throws \Exception case Middleware does not exists
     * @return mixed $middleware
     */
    protected function validateMiddleware($middleware)
    {
        if (! empty($middleware) && is_string($middleware)) {
            if (! class_exists($middleware)) {
                throw new \Exception("Error: Middleware {$middleware} does not exists");
            }
        } else if(is_array($middleware) && !empty($middleware)) {
            throw new \Exception("Error: Not suporting multiple Middlewares, what about you contribute with this?");
        }
        
        return $middleware;
    }

}