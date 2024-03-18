<?php

namespace Core;

use Core\Middleware\Middleware;

class Router
{
    protected $routes = [];

    public function add($method, $uri, $controller)
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware' => null,
        ];

        return $this;
    }

    public function get($uri, $controller)
    {

        return $this->add('GET', $uri, $controller);
    }
    public function post($uri, $controller)
    {

        return $this->add('POST', $uri, $controller);
    }
    public function put($uri, $controller)
    {

        return $this->add('PUT', $uri, $controller);
    }
    public function routes($uri, $method)
    {

        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && strtoupper($route['method']) === strtoupper($method)) { 
    
                Middleware::resolve($route['middleware']);
    
                return require base_path($route['controller']);
            }
        }
    }

    public function only($key)
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;

        return $this;
    }
}
