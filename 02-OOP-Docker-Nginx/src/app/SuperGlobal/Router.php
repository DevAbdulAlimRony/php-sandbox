<?php
namespace App\SuperGlobal;
use App\SuperGlobal\RouteNotFoundException;

class Router{
    private array $routes;

    public function registerBasic(string $route, callable|array $action): self{
        $this->routes[$route] = $action;
        return $this;
    }

    // Enhance Register to take get post etc request
    public function register(string $requstMethod, string $route, callable|array $action): self{
        $this->routes[$requstMethod][$route] = $action; // [get => ['/' => '[HomeClass, IndexMethod]'], post => ['/' => '[HomeClass, StoreMethod]']]
        return $this;
    }

    public function get(string $route, callable|array $action): self{
        return $this->register('get', $route, $action);
    }

    public function post(string $route, callable|array $action): self{
        return $this->register('post', $route, $action);
    }

    public function routes(): array{
        return $this->routes;
    }

    public function resolve(string $requestUri, string $requestMethod){
        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$requestMethod][$route] ?? null; // Returned the route's callable function
        if(! $action){
            throw new RouteNotFoundException();
        }

        // When we directly give function in register() callable argument
        if(is_callable($action)){
            return call_user_func($action); // called callable $action, Now It will perform operation of callable function of register
        }

        // When We give classname, and method as array in register's 2nd argument
        if(is_array($action)){
            [$class, $method] = $action;
            if(class_exists($class)){
                $class = new $class();

                if(method_exists($class, $method)){
                    return call_user_func_array([$class, $method], []);
                }
            }
        } 

        throw new RouteNotFoundException(); // when not callable or array passed
    }
}