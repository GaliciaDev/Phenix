<?php

namespace App\Http\Request;

class Request
{
    protected $method;
    protected $uri;
    protected $params;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->params = $_REQUEST;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getParams()
    {
        return $this->params;
    }
}