<?php

namespace App\Http\Controllers;

class APIController extends Controller
{
    public function respond($data, $statusCode = 200)
    {
        $data = is_null($data)? null : ['data' => $data];
        return response()->json($data, $statusCode);
    }

    public function respondSuccess()
    {
        return $this->respond(null);
    }

    public function respondCreated($data)
    {
        return $this->respond($data, 201);
    }

    public function respondNoContent()
    {
        return $this->respond(null, 204);
    }

    public function respondError($message, $statusCode = 500)
    {
        return response()->json([
            'error' => $message,
            'status_code' => $statusCode
        ], $statusCode);
    }

    public function respondUnauthorized($message = 'No autorizado')
    {
        return $this->respondError($message, 401);
    }

    public function respondForbidden($message = 'No permitido')
    {
        return $this->respondError($message, 403);
    }

    public function respondNotFound($message = 'Recurso no encontrado')
    {
        return $this->respondError($message, 404);
    }

    public function respondFailedLogin()
    {
        return $this->respond([
            'errors' => [
                'correo o password' => 'Credenciales inválidas.',
            ]
            ], 422);
    }
}
