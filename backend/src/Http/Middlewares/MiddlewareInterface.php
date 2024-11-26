<?php

namespace App\Http\Middleware;

use App\Http\Request\Request;
use App\Http\Response\Response;

interface MiddlewareInterface
{
    public function handle(Request $request, Response $response, callable $next);
}