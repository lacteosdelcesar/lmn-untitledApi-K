<?php

namespace App\Resources\Auth\Controllers;

use App\Core\BaseController;
use App\Resources\Auth\UserRepository;
use Illuminate\Http\Response;


class AuthController extends BaseController
{

    protected function repository()
    {
        return UserRepository::class;
    }

    /**
     * @return mixed
     */
    public function login()
    {
        $credentials = $this->request->only('username', 'password');

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
