<?php

namespace App\Http\Router;

use App\Http\Request\Request;
use App\Http\Response\Response;

class Router
{
    protected $routes = [];

    public function addRoute($method, $uri, $handler)
    {
        $this->routes[$method][$uri] = $handler;
    }

    public function dispatch(Request $request, Response $response)
    {
        $method = $request->getMethod();
        $uri = $request->getUri();

        if (isset($this->routes[$method][$uri])) {
            $handler = $this->routes[$method][$uri];
            call_user_func($handler, $request, $response);
        } else {
            $response->setStatusCode(404);
            $response->setBody('Not Found');
            $response->send();
        }
    }
}