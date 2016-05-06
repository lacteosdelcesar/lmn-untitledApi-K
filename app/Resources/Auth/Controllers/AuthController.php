<?php

namespace App\Resources\Auth\Controllers;

use App\Core\BaseController;
use Illuminate\Http\Response;

class AuthController extends BaseController
{
    /**
     * @return mixed
     */
    public function login()
    {
        $credentials = $this->request->only('nombre', 'password');

        if (!$token = \JWTAuth::attempt($credentials)) {
            return response()->json(['message' => 'invalid_credentials',], Response::HTTP_UNAUTHORIZED);
        }

        return $this->response->array(compact('token'));
    }

    /**
     * @return mixed
     */
    public function refreshToken()
    {
        $token = \JWTAuth::parseToken()->refresh();

        return $this->response->array(compact('token'));
    }

}
