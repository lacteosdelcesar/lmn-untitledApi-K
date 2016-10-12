<?php

namespace App\Resources\Auth\Controllers;

use App\Core\BaseController;
use App\Resources\Auth\Models\Rol;
use App\Resources\Auth\Models\User;
use App\Resources\Auth\UserRepository;


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
        $is_auth = true;

        if (!$token = \JWTAuth::attempt($credentials)) {
            $is_auth = $credentials['username'] == getenv('APP_SU_NAME') && $credentials['password'] == getenv('APP_SU_PASSWORD');
            if ($is_auth) {
                $user = new User([
                    'username' => $credentials['username'],
                    'rol_id' => 6
                ]);
                $token = \JWTAuth::fromUser($user);
            }
        }

        return $is_auth ? $this->response->array(compact('token')): $this->response->errorUnauthorized('invalid_credentials');
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
