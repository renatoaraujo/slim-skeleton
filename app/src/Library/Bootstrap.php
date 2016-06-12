<?php
namespace Skeleton\Library;

use \Slim\Container;
use \Slim\App;
use \Skeleton\Exception\SkeletonException;
use \Skeleton\Library\Debug;

/**
* Object to bootstrap the application
*
* @todo PHPDOC of the methods and refactoring of the code to make it understandable
*
* @author Renato Rodrigues de Araujo <renato.r.araujo@gmail.com>
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
  * Method to inject the dependencies services on application bootstrap
  *
  * @param array $dependencies
  *            dependencies declared like [name=>service]
  * @return \Skeleton\Library\Bootstrap instance
  */
  public function injectDependecy(array $dependencies)
  {
    if (is_array($dependencies) && ! empty($dependencies)) {
      foreach ($dependencies as $name => $service) {

        $name = $this->validateDependencyName($name);

        if (is_array($service) && ! empty($service)) {
          $dependency = $service['dependency'];
          $service = $service['service'];
          $service = $this->validateCallable(new $service($this->container[$dependency]));
        } else {
          if (gettype($service) == 'string') {
            $service = $this->validateCallable(new $service());
          } else {
            if (! (gettype($service) == 'object' && $service instanceof \Closure)) {
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
  * Method to validate the service name to dependency container
  *
  * @param string $name
  * @return string $name
  */
  protected function validateDependencyName($name)
  {
    $allowedChars = "/^[a-zA-Z]+$/";

    if (! preg_match($allowedChars, $name)) {
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

      if (isset($arr_route['middleware']) && ! empty($arr_route['middleware'])) {
        $this->$arr_route['method']($arr_route['url'], "{$arr_route['callback']}")
        ->add($arr_route['middleware'])
        ->setName($name);
      } else {
        $this->$arr_route['method']($arr_route['url'], "{$arr_route['callback']}")->setName($name);
      }
    }
  }

  /**
  *
  * @param unknown $name
  * @param unknown $route
  */
  protected function validateRoute($name, $route)
  {
    $arr_route = [];

    if (array_key_exists('method', $route)) {
      $arr_route['method'] = $method = $route['method'];
    } else {
      throw new SkeletonException("Error: You need to declare the HTTP method in route {$name}");
    }

    if ($method && $method != 'group') {
      if (array_key_exists('url', $route)) {
        $arr_route['url'] = $url = $route['url'];
      } else {
        throw new SkeletonException("Error: Please specify the URL in route {$name}");
      }

      if (array_key_exists('callback', $route)) {
        $arr_route['callback'] = $this->validateCallback($route['callback'], $name);
      } else {
        throw new SkeletonException("Error: you need to declare the callback in route {$name}");
      }
    } else {
      if (array_key_exists('group', $route)) {
        $group = $route['group'];
      } else {
        throw new SkeletonException("Error: You need to declare the group in array to use this HTTP method {$name}");
      }

      if ($group && (is_array($group) && ! empty($group))) {
        foreach ($group as $key => $value) {
          if (array_key_exists('url', $g)) {
            $url = $g['url'];
          } else {
            throw new SkeletonException("Please specify the URL in group {$key} in route {$name}");
          }

          if (array_key_exists('callback', $g)) {
            $this->validateCallback($g['callback'], $name);
          } else {
            throw new SkeletonException("Error: you need to declare the callback in group {$g['key']} in route {$name}");
          }
        }
      }
    }

    if (array_key_exists('middleware', $route)) {
      $arr_route['middleware'] = $this->validateCallable(new $route['middleware']());
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
        throw new SkeletonException("Error: you need to declare the controller in route {$name}");
      }

      if (array_key_exists('function', $callback)) {
        $function = $callback['function'];
      } else {
        throw new SkeletonException("Error: you need to declare the function in route {$name} or use the callback as string.");
      }

      if (is_string($controller) && is_string($function)) {
        if (class_exists($controller)) {
          if (method_exists($controller, $function)) {
            $callback = "{$controller}:{$function}";
          } else {
            throw new SkeletonException("Error: method {$function} inexistent in route {$name}");
          }
        } else {
          throw new SkeletonException("Error: callback class not existent in route {$name}");
        }
      } else {
        throw new SkeletonException("Error you need to use string to declare your callback in route {$name}");
      }
    } else {
      if ($callback && (is_string($callback) && ! emtpy($callback))) {
        if (! class_exists($callback)) {
          throw new SkeletonException("Error: callback class not existent in route {$name}");
        }
      } else {
        throw new SkeletonException("Error: callback need to be declared in route {$name}");
      }
    }

    return $callback;
  }

  /**
  * Method to add generic middlewares for application.
  *
  * @param array $middlewares
  * @return \Skeleton\Library\Bootstrap instance
  */
  public function addGenericMiddleware(array $middlewares)
  {
    if (is_array($middlewares) && ! empty($middlewares)) {
      foreach ($middlewares as $middleware) {

        $middleware = $this->validateCallable(new $middleware());
        $this->add($middleware);
      }
    }
    return $this;
  }

  /**
  * Method to validate the callable/existent object
  *
  * @param Object $object
  * @return Object $object
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
