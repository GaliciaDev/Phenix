<?php

namespace App\Http\Controllers;

use App\Http\Request\Request;
use App\Http\Response\Response;

class BaseController
{
    protected function jsonResponse(Response $response, $data, $statusCode = 200)
    {
        $response->setStatusCode($statusCode);
        $response->addHeader('Content-Type: application/json');
        $response->setBody(json_encode($data));
        $response->send();
    }
}