<?php

namespace App\Http\Controllers;

use App\Http\Request\Request;
use App\Http\Response\Response;

class UserController extends BaseController
{
    public function getUser(Request $request, Response $response)
    {
        // Aquí iría la lógica para obtener un usuario de la base de datos
        $user = ['id' => 1, 'name' => 'John Doe'];
        $this->jsonResponse($response, $user);
    }
}