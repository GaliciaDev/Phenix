<?php

namespace App\Http\Middleware;

use App\Http\Request\Request;
use App\Http\Response\Response;

class AuthMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Response $response, callable $next)
    {
        // Aquí iría la lógica de autenticación
        $authenticated = true; // Esto es solo un ejemplo

        if ($authenticated) {
            return $next($request, $response);
        } else {
            $response->setStatusCode(401);
            $response->setBody('Unauthorized');
            $response->send();
        }
    }
}